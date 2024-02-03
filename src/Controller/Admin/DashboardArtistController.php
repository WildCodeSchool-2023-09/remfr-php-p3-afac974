<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/dashboard/artist', name: 'admin_artist_')]
class DashboardArtistController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function showArtist(
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        // Barre de recherche

        $form = $this->createFormBuilder(null, [
            'method' => 'get',
        ])
            ->add('search', SearchType::class, [
                'label' => 'Nom',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary'], // Vous pouvez personnaliser les classes CSS ici
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->get('search')->getData();
            $query = $userRepository->findLikeNameArtist($search);
        } else {
            $query = $userRepository->queryFindAllArtist();
        }

         // pagination de la galerie d'artistes version admin
         $pagination = $paginator->paginate(
             $query,
             $request->query->getInt('page', 1), /*page number*/
             5/*limit per page*/
         );

        return $this->render('admin/artist/index.html.twig', [
            'artists' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteArtist(
        Request $request,
        int $id,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $submittedToken)) {
            $artist = $entityManager->find(User::class, $id);
            $entityManager->remove($artist);
            $entityManager->flush();

            $this->addFlash('danger', 'This artist has been deleted successfully');
        }

        return $this->redirectToRoute('admin_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
