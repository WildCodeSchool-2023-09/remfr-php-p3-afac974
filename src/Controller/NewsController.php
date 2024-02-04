<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Newsletter;
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
}
