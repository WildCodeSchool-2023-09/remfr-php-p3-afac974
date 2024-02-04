<?php

namespace App\Controller;

use App\Entity\Expo;
use App\Entity\News;
use App\Entity\User;
use App\Form\ExpoType;
use App\Repository\ExpoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/expo', name: 'expo_')]
class ExpoController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(
        Expo $expo,
        ExpoRepository $expoRepository,
        Request $request,
        PaginatorInterface $paginator,
    ): Response {

        $pagination = $paginator->paginate(
            $expoRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        return $this->render('expo/index.html.twig', [
            'expos' => $pagination,
        ]);
    }

    #[Route('/new', name:'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $expo = new Expo();

        $form = $this->createForm(ExpoType::class, $expo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($expo);
            $entityManager->flush();

             // Créez une nouvelle entité News
             $news = new News();
             $news->setTitle($expo->getTitle());
             $news->setDescription($expo->getDescription());
             // Ajoutez d'autres champs si nécessaire

             // Persistez la nouvelle entité News
             $entityManager->persist($news);
             $entityManager->flush();

            return $this->redirectToRoute('expo_index');
        }

        return $this->render('expo/new.html.twig', ['form' => $form]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Expo $expo, ExpoRepository $expoRepository, Request $request): Response
    {

        $expo = $expoRepository->findOneBy(['id' => $expo->getId()]);

        return $this->render('expo/show.html.twig', [
            'expo' => $expo,
        ]);
    }

    #[Route('/showMyExpos', name: 'showMyExpos')]
    public function showMyExpos(EntityManagerInterface $entityManager, Security $security): Response
    {
        // Récupérer l'utilisateur actuellement connecté et ses expositions
        $user = $security->getUser();
        $expos = $user->getExpos();

        return $this->render('expo/showMyExpos.html.twig', [
            'expos' => $expos, // Passer les expositions à la vue
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, Expo $expo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExpoType::class, $expo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'This expo has been edited successfully');

            return $this->redirectToRoute('expo_showMyExpos');
        }

        return $this->render('expo/edit.html.twig', [
            'form' => $form->createView(),
            'expo' => $expo,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Expo $expo,
        EntityManagerInterface $entityManager
    ): Response {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $expo->getId(), $submittedToken)) {
            $artist = $expo->getUser();
            $artist->getExpos();

            if ($artist) {
                $artist->removeExpo($expo);
            }

            $entityManager->remove($expo);
            $entityManager->flush();

            $this->addFlash('danger', 'This expo has been deleted successfully');
        }

        return $this->redirectToRoute('expo_index', [], Response::HTTP_SEE_OTHER);
    }
}
