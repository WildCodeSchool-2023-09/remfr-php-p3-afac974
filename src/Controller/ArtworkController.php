<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArtworkType;
use App\Entity\Artwork;
use App\Entity\Artist;
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

    #[Route('/showArtworks/{id}', name: 'show_artworks')]
    public function showArtworks(Artist $artist): Response
    {
        return $this->render('artwork/show_artworks_artist.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/editArtwork/{id}', name: 'edit_artwork')]
    public function editArtwork(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtworkType::class, $artwork);
        $artist = $artwork->getArtist();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('pictureFile')->getData();
            if ($pictureFile) {
                $artwork->setPictureFile($pictureFile);
            }
            $entityManager->flush();

            $this->addFlash('success', 'The artwork has been edited successfully');

            return $this->redirectToRoute('artwork_show_artworks', ['id' => $artist->getId()]);
        }

        return $this->render('artwork/edit_artwork_artist.html.twig', [
            'form' => $form->createView(),
            'artwork' => $artwork,
            'artist' => $artist,
        ]);
    }

    #[Route('/deleteArtwork/{id}', name: 'delete_artwork')]
    public function deleteArtwork(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response
    {
        $artist = $artwork->getArtist();
        $entityManager->remove($artwork);
        $entityManager->flush();

        $this->addFlash('danger', 'This artwork has been deleted successfully');

        return $this->redirectToRoute('artwork_show_artworks', ['id' => $artist->getId()], Response::HTTP_SEE_OTHER);
    }

    //Return the page for a specific artwork
    #[Route('/show/{id}', name:'show')]
    public function show(Artwork $artwork): Response
    {
        return $this->render('artwork/artwork.html.twig', ['artwork' => $artwork]);
    }
}
