<?php

namespace App\Controller\Admin;

use App\Entity\Expo;
use App\Form\ExpoType;
use App\Repository\ExpoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/dashboard/expo', name: 'admin_expo_')]
class DashboardExpoController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(
        ExpoRepository $expoRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $pagination = $paginator->paginate(
            $expoRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('admin/expo/index.html.twig', [
            'expos' => $pagination,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteExpo(Request $request, Expo $expo, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $expo->getId(), $submittedToken)) {
            $entityManager->remove($expo);
            $entityManager->flush();

            $this->addFlash('danger', 'This expo has been deleted successfully');
        }

        return $this->redirectToRoute('admin_expo_index', [], Response::HTTP_SEE_OTHER);
    }
}
