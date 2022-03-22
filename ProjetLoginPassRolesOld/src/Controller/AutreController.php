<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Routing\Annotation\Route;

class AutreController extends AbstractController
{
    // ces routes sont accessibles par tout le monde, le contrôle est realisé à l'interieure

    #[Route("/autre/action1")]
    public function action1()
    {
        // deux rôles peuvent avoir l'accès
        // mais il y a un bug! this->denyAccessUnlessGranted(['ROLE_CLIENT','ROLE_ADMIN']);

        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        return $this->render('autre/action1.html.twig');
    }


    #[Route("/autre/action2")]
    public function action2()
    {

        // deux rôles peuvent avoir l'accès
        // mais il y a un bug! this->denyAccessUnlessGranted(['ROLE_CLIENT','ROLE_ADMIN']);

        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        // si pas d'exception...
        return $this->render('autre/action2.html.twig');
    }

    #[Route("/autre/action3")]
    public function action3()
    {
        // cette fois on va controller l'accès dans la vue
        return $this->render('autre/action3.html.twig');
    }
}
