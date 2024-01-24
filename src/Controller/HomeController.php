<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\ArtworkRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'home_')]

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArtworkRepository $artworkRepository): Response
    {
        $artworks = $artworkRepository->findAll();
        return $this->render('home/index.html.twig', ['artworks' => $artworks]);
    }

    #[Route('/aboutUs', name: 'about_us')]
    public function show(): Response
    {
        return $this->render('home/aboutUs.html.twig');
    }
    #[Route('/gallery', name: 'gallery')]
    public function showGallery(
        ArtworkRepository $artworkRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        // Barre de recherche

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
            3 /*limit per page*/
        );

        return $this->render('home/gallery.html.twig', [
            'artworks' => $pagination,
            'form' => $form,
        ]);
    }

    public function flashMessageSuccessConnection(SessionInterface $session): Response
    {
        $successMessage = $session->get('successConnection');
        return $this->render('base.html.twig', [
            'successMessage' => $successMessage,]);
    }
    #[Route('/artists', name: 'artists')]
    public function showArtists(): Response
    {
        return $this->render('home/artists.html.twig');
    }
    #[Route('/biography', name: 'biography')]
    public function showBiography(): Response
    {
        return $this->render('home/biography.html.twig');
    }
    #[Route('/mentions', name: 'mentions')]
    public function showMentions(): Response
    {
        return $this->render('home/mentions.html.twig');
    }
}
