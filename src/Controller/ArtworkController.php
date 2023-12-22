<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/artwork', name:'artwork_')]
class ArtworkController extends AbstractController
{
    //Return the page for a specific artwork
    #[Route('/show', name:'show')]
    public function show(): Response
    {
        return $this->render('artwork/artwork.html.twig');
    }
}
