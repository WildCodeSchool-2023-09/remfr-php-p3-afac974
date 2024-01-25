<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/{id}/delete', name: 'delete')]
    public function deleteComment(Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $user = $comment->getAuthor();
        $user->removeComment($comment);

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('artwork_show', ['id' => $comment->getArtwork()->getId()]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function editComment(Comment $comment, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a été modifié avec succès.');

            return $this->redirectToRoute('artwork_show', ['id' => $comment->getArtwork()->getId()]);
        }

        return $this->render('comment/edit.html.twig', [
            'artwork' => $comment->getArtwork(),
            'form' => $form->createView(),
        ]);
    }
}
