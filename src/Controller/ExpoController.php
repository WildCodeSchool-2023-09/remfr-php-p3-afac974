<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\Expo;
use App\Form\ExpoType;
use App\Repository\ArtistRepository;
use App\Repository\ExpoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/expo', name: 'expo_')]
class ExpoController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        ExpoRepository $expoRepository,
        ArtistRepository $artistRepository,
        Security $security
    ): Response {
        $expos = $expoRepository->findAll();
        $user = $security->getUser();
        $artist = $artistRepository->findOneBy(['user' => $user]);

        return $this->render('expo/index.html.twig', [
            'expos' => $expos,
            'artist' => $artist
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        // $user = $security->getUser();
        // $artist = $artistRepository->findOneBy(['user' => $user]);
        $expo = new Expo();
        $form = $this->createForm(ExpoType::class, $expo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$expo->setArtist($artist);
            $entityManager->persist($expo);
            $entityManager->flush();

            return $this->redirectToRoute('expo_index');
        }

        return $this->render('expo/expo.html.twig', ['expo' => $expo, 'form' => $form,]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Expo $expo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExpoType::class, $expo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('expo_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('expo/edit.html.twig', [
            'expo' => $expo,
            'form' => $form
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Expo $expo, EntityManagerInterface $entityManager): Response
    {
        if ($this->iscsrfTokenValid('delete' . $expo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($expo);
            $entityManager->flush();
        }
        $this->addFlash('Danger!!', 'L\'Expo a été supprimée');
        return $this->redirectToRoute('expo_index', [], Response::HTTP_SEE_OTHER);
    }
}
