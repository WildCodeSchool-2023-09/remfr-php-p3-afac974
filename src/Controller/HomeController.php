<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home_')]

class HomeController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/aboutUs', name: 'about_us')]
    public function show(): Response
    {
        return $this->render('home/aboutUs.html.twig');
    }
    #[Route('/gallery', name: 'gallery')]
    public function showGallery(): Response
    {
        return $this->render('home/gallery.html.twig');
    }
}
