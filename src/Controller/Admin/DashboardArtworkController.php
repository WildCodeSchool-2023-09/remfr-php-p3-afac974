<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/dashboard/artwork', name: 'admin_artwork_')]
class DashboardArtworkController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function showArtworks(
        ArtworkRepository $artworkRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
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

    #[Route('/edit/{id}', name: 'edit')]
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

            return $this->redirectToRoute('admin_artwork_index');
        }

        return $this->render('admin/artwork/edit.html.twig', [
            'form' => $form->createView(),
            'artwork' => $artwork,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function deleteArtwork(
        Request $request,
        Artwork $artwork,
        EntityManagerInterface $entityManager
    ): Response {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $submittedToken)) {
            //Obtenir l'artiste lié à l'œuvre d'art
            $artist = $artwork->getUser();
            $artist->getArtworks();

            // Utilisez la méthode removeArtwork de l'artiste pour gérer la suppression ( seul moyen trouvé)
            if ($artist) {
                $artist->removeArtwork($artwork);
            }

            if ($artwork->getType()) {
                $artwork->removeType($artwork->getType());
            }

            $entityManager->remove($artwork);
            $entityManager->flush();

            $this->addFlash('danger', 'This artwork has been deleted successfully');
        }

        return $this->redirectToRoute('admin_artwork_index', [], Response::HTTP_SEE_OTHER);
    }
}
