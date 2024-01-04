<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class LoginController extends AbstractController
{
    public function isConnected(Security $security)
    {
        // Vérifier si un utilisateur est connecté
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // L'utilisateur est connecté
            // Faire quelque chose ici
        } else {
            // L'utilisateur n'est pas connecté
            // Faire quelque chose d'autre ici
        }
        // ...
    }
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,'error' => $error,
        ]);
    }
}
