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

        $em = $doctrine->getManager();
        // créer une commande, la persister et puis affecter cette commande
        // avec la commande de la session (rajouter les détails - et eventuellement un client)
        $commandeBD = new Commande();
        $em->persist($commandeBD);
        
        // on initisalise tout ce qu'on a de la commande avant de faire le persist
        // (client - $this->getUser(), dateCreation, etc...)
        // et puis on copie les détails du panier 
        $commandeBD->setDateCreation(new DateTime());

        foreach ($commandePanier->getDetails() as $detail) {
            
            // Dans notre cas il y a cascade persist uniquement dans les rélations OneToMany, pas ManyToOne

            // Créer un détail vide
            $detailBD = new DetailCommande();
            // Affecter la commande du détail
            $detailBD->setCommande($commandeBD);
    
            // obtenir le produit de la BD à nouveau, sans aucun lien avec les autres entités du panier
            $produit = $doctrine->getRepository(Produit::class)->find($detail->getProduit()->getId());
            
            // Affecter le produit du détail
            $detailBD->setProduit($produit);
            // Affecter la quantité
            $detailBD->setQuantite($detail->getQuantite());

            // Persister le détail (la commande est déjà persistée - dans cette même méthode . Le produit aussi, on vient de l'obtenir de la BD)
            $em->persist($detailBD);
            
            
        }
        $em->flush(); // mettre à jour une fois les détails sont là

        $vars = ['commandeBD' => $commandeBD];
        return $this->render('commande/commande_passer.html.twig', $vars);
    }
}
