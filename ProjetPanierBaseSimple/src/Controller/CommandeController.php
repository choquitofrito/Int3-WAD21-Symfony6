<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\Produit;
use App\Repository\CommandeRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    #[Route('/commande/passer', name: 'commande_passer')]
    public function commandePasser(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {

        $commandePanier = $session->get("panierCommande");

        // créer une commande, la persister et puis affecter cette commande
        // avec la commande de la session (rajouter les détails - et eventuellement un client)
        $commandeBD = new Commande();
        $em = $doctrine->getManager();
        // on initisalise tout ce qu'on a de la commande avant de faire le persist
        // (client - $this->getUser(), dateCreation, etc...)
        // et puis on copie les détails du panier 
        $commandeBD->setDateCreation(new DateTime());
        $em->persist($commandeBD);
        $em->flush();

        // on a maintenant une commande avec un id
        foreach ($commandePanier->getDetails() as $detail) {
            $commandeBD->addDetail($detail);
            
            
        }
        $em->persist($commandeBD);
        $em->flush(); // mettre à jour une fois les détails sont là

        $vars = ['commandeBD' => $commandeBD];
        return $this->render('commande/commande_passer.html.twig', $vars);
    }
}
