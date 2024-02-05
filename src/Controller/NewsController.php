<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Newsletter;
use App\Entity\Expo;
use App\Entity\User;
use App\Repository\ExpoRepository;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/news', name: 'news_')]
class NewsController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(
        News $news,
        NewsRepository $newsRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $pagination = $paginator->paginate(
            $news = $newsRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );


        return $this->render('newsletter/index.html.twig', [
            'news' => $pagination,
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(
        News $news,
        NewsRepository $newsRepository,
        ExpoRepository $expoRepository,
        Request $request
    ): Response {
        $news = $newsRepository->findOneBy(['id' => $news->getId()]);

        $expo = null;
        if ($news->getExpoId()) {
            $expo = $expoRepository->findOneBy(['id' => $news->getExpoId()]);
        }

        return $this->render('newsletter/show.html.twig', [
            'news' => $news,
            'expo' => $expo,
        ]);
    }
}
