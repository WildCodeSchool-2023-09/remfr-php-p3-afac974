<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Comment;
use App\Entity\User;

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
}
