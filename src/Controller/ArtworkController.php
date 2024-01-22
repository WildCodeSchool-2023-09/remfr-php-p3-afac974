<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArtworkType;
use App\Entity\Artwork;
use App\Repository\ArtworkRepository;

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
    public function show(Artwork $artwork): Response
    {
        return $this->render('artwork/artwork.html.twig', ['artwork' => $artwork]);
    }
}
