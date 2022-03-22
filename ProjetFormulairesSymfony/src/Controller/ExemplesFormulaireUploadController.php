<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pays;
use App\Form\PaysType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;


class ExemplesFormulaireUploadController extends AbstractController
{
    #[Route ("/exemples/formulaire/upload/exemple")]
    public function exemple (Request $request, ManagerRegistry $doctrine){
        // créer une nouvelle entité vide
        $pays = new Pays();
        // créer un formulaire associé à cette entité
        $formulairePays = $this->createForm (PaysType::class, $pays);
        // gérer la requête (et hydrater l'entité)
        $formulairePays->handleRequest($request);
        // vérifier que le formulaire a été envoyé (isSubmitted) et que les données sont valides
        if ($formulairePays->isSubmitted() && $formulairePays->isValid()){
            // obtenir le fichier (pas un "string" mais un objet de la class UploadedFile)
            $fichier = $pays->getLienImage();
            // obtenir un nom de fichier unique pour éviter les doublons dans le dossier
            $nomFichierServeur = md5(uniqid()).".".$fichier->guessExtension();
            // stocker le fichier dans le serveur (on peut indiquer un dossier)
            $fichier->move ("dossierFichiers", $nomFichierServeur);
            // affecter le nom du fichier de l'entité. Ça sera le nom qu'on
            // aura dans la BD (un string, pas un objet UploadedFile cette fois)
            $pays->setLienImage($nomFichierServeur);

            // stocker l'objet dans la BD, ou faire update
            $em = $doctrine->getManager();
            $em->persist($pays);
            $em->flush();
            return new Response ("fichier uploaded dans le dossier indiqué dans l'action, BD mise à jour!");
        }
        else {
            return $this->render ("/exemples_formulaires_upload/affichage.html.twig",
                    ['formulaire'=> $formulairePays->createView()]);
        }

    }
}