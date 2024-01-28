<?php

namespace App\Controller;

use App\Entity\Type;
use App\Entity\User;
use App\Entity\Artist;
use App\Entity\Artwork;
use App\Entity\Contact;
use App\Form\ArtistType;
use App\Form\ArtworkType;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('admin/index.html.twig', ['user' => $user]);
    }

    #[Route('/showUsers', name: 'show_users')]
    public function showUsers(
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        // Barre de recherche

         $form = $this->createFormBuilder(null, [
            'method' => 'get',
        ])
            ->add('search', SearchType::class, [
                'label' => 'Nom',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary'], // Vous pouvez personnaliser les classes CSS ici
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $userRepository->findLikeName($search);
        } else {
            $query = $userRepository->queryFindAllUser();
        }

         // pagination de la gallerie d'art
         $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            5/*limit per page*/
        );

        return $this->render('admin/show_users.html.twig', [
            'users' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editUser/{id}', name: 'edit_user')]
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = $form->get('roles')->getData();

            $user->setRoles($roles);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'The user has been edited successfully');

            return $this->redirectToRoute('admin_show_users');
        }

        return $this->render('admin/edit_user.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/deleteUser/{id}', name: 'delete_user')]
    public function deleteUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $submittedToken)) {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('danger', 'This user has been deleted successfully');
        }

        return $this->redirectToRoute('admin_show_users', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/showArtist', name: 'show_artists')]
    public function showArtist(
        Artist $artist, 
        ArtistRepository $artistRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {

        // Barre de recherche

        $form = $this->createFormBuilder(null, [
            'method' => 'get',
        ])
            ->add('search', SearchType::class, [
                'label' => 'Nom',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary'], // Vous pouvez personnaliser les classes CSS ici
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $artistRepository->findLikeName($search);
        } else {
            $query = $artistRepository->queryFindAllArtist();
        }

         // pagination de la galerie d'artistes version admin
         $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            5/*limit per page*/
        );

        return $this->render('admin/show_artists.html.twig', [
            'artists' => $pagination,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/editArtist/{id}', name: 'edit_artist')]
    public function editArtist(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $posterFile = $form->get('posterFile')->getData();
            if ($posterFile) {
                $artist->setPosterFile($posterFile);
            }
            $entityManager->flush();

            $this->addFlash('success', 'The artist has been edited successfully');

            return $this->redirectToRoute('admin_show_artists');
        }

        return $this->render('admin/edit_artist.html.twig', [
            'form' => $form->createView(),
            'artist' => $artist,
        ]);
    }

    #[Route('/deleteArtist/{id}', name: 'delete_artist')]
    public function deleteArtist(Request $request, $id , Artist $artist, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $submittedToken)) {

            $artist = $entityManager->find(Artist::class, $id);
            // Supprimez les œuvres d'art associées à l'artiste
            foreach ($artist->getArtworks() as $artwork) {
                $artist->removeArtwork($artwork);
                $entityManager->remove($artwork);
            }

            $entityManager->remove($artist);
            $entityManager->flush();

            $this->addFlash('danger', 'This artist has been deleted successfully');
        }

        return $this->redirectToRoute('admin_show_artists', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/showContact', name: 'show_contacts')]
    public function showContact(
        ContactRepository $contactRepository,
        PaginatorInterface $paginator,
        Request $request): Response
    {
        $query = $contactRepository->findAll();
        // Barre de recherche
        $form = $this->createFormBuilder(null, [
            'method' => 'get',
        ])
            ->add('demandType', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Retour sur l\'exposition' => 'retour_exposition',
                    'Demande de rôle artiste' => 'demande_role_artiste',
                    'Axe d\'amélioration' => 'axe_amelioration',
                    'Problème rencontré' => 'probleme_rencontre',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary'], // Vous pouvez personnaliser les classes CSS ici
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $demandType = $form->get('demandType')->getData();
            $query = $contactRepository->findByDemandType($demandType);
        } else {
            $query = $contactRepository->queryFindAllContact();
        }

        // pagination des demandes de contact
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            5/*limit per page*/
        );

        return $this->render('admin/show_contacts.html.twig', [
            'contacts' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteContact/{id}', name: 'delete_contact')]
    public function deleteContact(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $submittedToken)) {
            $entityManager->remove($contact);
            $entityManager->flush();

            $this->addFlash('danger', 'This contact has been deleted successfully');
        }

        return $this->redirectToRoute('admin_show_contacts', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/showArtworks', name: 'show_artworks')]
    public function showArtworks(
        ArtworkRepository $artworkRepository,
        PaginatorInterface $paginator,
        Request $request
        ): Response
    {
        $form = $this->createFormBuilder(null, [
            'method' => 'get',
        ])
            ->add('search', SearchType::class, [
                'label' => 'Nom',
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'pl-2'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary'], // Vous pouvez personnaliser les classes CSS ici
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $type = $form->get('type')->getData();
            $query = $artworkRepository->findLikeTitle($search, $type);
        } else {
            $query = $artworkRepository->queryFindAllArtwork();
        }
        // pagination de la gallerie d'art
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            5/*limit per page*/
        );

        return $this->render('admin/show_artworks.html.twig', [
            'artworks' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/editArtwork/{id}', name: 'edit_artwork')]
    public function editArtwork(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtworkType::class, $artwork);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('pictureFile')->getData();
            if ($pictureFile) {
                $artwork->setPictureFile($pictureFile);
            }
            $entityManager->flush();

            $this->addFlash('success', 'The artwork has been edited successfully');

            return $this->redirectToRoute('admin_show_artworks');
        }

        return $this->render('admin/edit_artwork.html.twig', [
            'form' => $form->createView(),
            'artwork' => $artwork,
        ]);
    }

    #[Route('/deleteArtwork/{id}', name: 'delete_artwork')]
    public function deleteArtwork(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $submittedToken)) {

            // Obtenir l'artiste lié à l'œuvre d'art
            $artist = $artwork->getArtist();
            $artist->getArtworks();

            // Utilisez la méthode removeArtwork de l'artiste pour gérer la suppression ( seul moyen trouvé)
            if ($artist) {
                $artist->removeArtwork($artwork);
            }

            if ($artwork->getType()) {
                $artwork->removeType($artwork->getType());
            }
            $entityManager->remove($artwork);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                // Affichez l'erreur pour obtenir plus d'informations
                die($e->getMessage());
            }
            $this->addFlash('danger', 'This artwork has been deleted successfully');
        }

        return $this->redirectToRoute('admin_show_artworks', [], Response::HTTP_SEE_OTHER);
    }
}
