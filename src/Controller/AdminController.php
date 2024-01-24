<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Repository\UserRepository;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\ContactRepository;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\Artist;
use App\Entity\Artwork;
use App\Form\AdminUserType;
use App\Form\ArtistType;
use App\Form\ArtworkType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();

        if ($user !== null) {
            $usernameAdmin = $user->getUsername();
        } else {
            $usernameAdmin = 'Utilisateur non connecté';
        }

        return $this->render('admin/index.html.twig', [
            'usernameAdmin' => $usernameAdmin,
        ]);
    }

    #[Route('/showUsers', name: 'show_users')]
    public function showUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/show_users.html.twig', [
            'users' => $users,
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
    public function showArtist(ArtistRepository $artistRepository): Response
    {

        $artists = $artistRepository->findAll();

        return $this->render('admin/show_artists.html.twig', [
            'artists' => $artists,
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
    public function deleteArtist(Request $request, Artist $artist, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $submittedToken)) {
            $entityManager->remove($artist);
            $entityManager->flush();

            $this->addFlash('danger', 'This artist has been deleted successfully');
        }

        return $this->redirectToRoute('admin_show_artists', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/showContact', name: 'show_contacts')]
    public function showContact(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('admin/show_contacts.html.twig', [
            'contacts' => $contacts,
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
    public function showArtworks(ArtworkRepository $artworkRepository): Response
    {
        $artworks = $artworkRepository->findAll();

        return $this->render('admin/show_artworks.html.twig', [
            'artworks' => $artworks,
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

        $entityManager->remove($artwork);
        $entityManager->flush();

        $this->addFlash('danger', 'This artwork has been deleted successfully');

        return $this->redirectToRoute('admin_show_artworks', [], Response::HTTP_SEE_OTHER);
    }
}
