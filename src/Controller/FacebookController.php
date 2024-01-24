<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FacebookController extends AbstractController
{
    #[Route("/connect/facebook", name:"connect_facebook_start")]
    public function connectAction(ClientRegistry $clientRegistry): Response
    {
        // on Symfony 3.3 or lower, $clientRegistry = $this->get('knpu.oauth2.registry');

        // will redirect to Facebook!
        return $clientRegistry
            ->getClient('facebook_main') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
                'public_profile'], ['email' // the scopes you want to access
                ]);
    }


    #[Route("/connect/facebook/check", name:"connect_facebook_check")]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry): Response
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)
        $client = $clientRegistry->getClient('facebook_main');

        try {
            // the exact class depends on which provider you're using
            $client->fetchUser();

            // do something with all this new power!
            // e.g. $name = $user->getFirstName();
            die;
            // ...
        } catch (\Exception $e) {
            return new Response('Error during Facebook authentication', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
