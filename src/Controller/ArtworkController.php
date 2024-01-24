<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArtworkType;
use App\Form\CommentType;
use App\Entity\Artwork;
use App\Entity\Comment;
use App\Repository\ArtworkRepository;
use App\Repository\CommentRepository;

#[Route('/artwork', name:'artwork_')]
class ArtworkController extends AbstractController
{
    //Add a new artwork to the database
    #[Route('/new', name:'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artwork = new Artwork();

        //Create the form
        $form = $this->createForm(ArtworkType::class, $artwork);
        //Get data from HTTP request
        $form->handleRequest($request);
        //Verify the form
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artwork);
            $entityManager->flush();

            return $this->redirectToRoute('home_gallery');
        }

        //Render the form
        return $this->render('artwork/new.html.twig', ['form' => $form]);
    }

    //Return the page for a specific artwork
    #[Route('/show/{id}', name:'show')]
    public function show(
        Artwork $artwork,
        EntityManagerInterface $entityManager,
        CommentRepository $commentRepository,
        Request $request
    ): Response {
        $comments = $commentRepository->findBy(['artwork' => $artwork], ['createdAt' => 'ASC']);
        $comment = new Comment();
        $comment->setArtwork($artwork);
        $comment->setAuthor($this->getUser());

        $comment->setCreatedAt();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persistez le commentaire dans la base de données
            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirigez l'utilisateur après avoir soumis le commentaire
            return $this->redirectToRoute('artwork_show', ['id' => $artwork->getId()]);
        }

        return $this->render('artwork/artwork.html.twig', [
            'artwork' => $artwork,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }
}
