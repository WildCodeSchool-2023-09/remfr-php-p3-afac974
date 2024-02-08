<?php

namespace App\Controller\Admin;

use App\Entity\Expo;
use App\Entity\News;
use App\Form\NewsType;
use App\Repository\ExpoRepository;
use App\Repository\NewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/dashboard/new', name: 'admin_news_')]
class DashboardNewsController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(
        NewsRepository $newsRepository,
        ExpoRepository $expoRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $pagination = $paginator->paginate(
            $newsRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        $expos = [];
        foreach ($pagination as $news) {
            $expoId = $news->getExpoId();
            if ($expoId !== null) {
                $expos[$expoId] = $expoRepository->findOneBy(['id' => $expoId]);
            }
        }

        return $this->render('admin/news/index.html.twig', [
            'news' => $pagination,
            //'expos' => $expos,
        ]);
    }

    #[Route('/new', name:'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $news = new News();

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('admin_news_index');
        }

        //Render the form
        return $this->render('admin/news/new.html.twig', ['form' => $form]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteNews(Request $request, News $news, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $news->getId(), $submittedToken)) {
            $entityManager->remove($news);
            $entityManager->flush();

            $this->addFlash('danger', 'This news has been deleted successfully');
        }

        return $this->redirectToRoute('admin_news_index', [], Response::HTTP_SEE_OTHER);
    }
}
