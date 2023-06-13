<?php

namespace App\Controller;


use App\Entity\Devis;
use App\Entity\User;
use App\Entity\Haie;

use App\Form\DevisType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class DevisCreerController extends AbstractController
{
    #[Route('/devis/creer', name: 'app_devis_creer')]
    public function index(ManagerRegistry $doctrine, SessionInterface $session, Request $request): Response
    {

        $request = Request::createFromGlobals();

        $entityManager = $doctrine->getManager();

        $choix = $session->get('choix');
        $haie = $session->get('haie');
        $hauteur = $session->get('hauteur');
        $longueur = $session->get('longueur');
        // Effectuer le calcul du prix en fonction de la longueur, de la hauteur et du coefficient
        if ($hauteur > 1.50) {
            $coeff = 1.5;
        } else {
            $coeff = 1;
        }

        $maHaie = $doctrine->getRepository(Haie::class)->find($haie);
        $prixHaie = $maHaie->getPrix();
        $prix = $prixHaie * $longueur * $coeff;

        // Appliquer une remise pour les entreprises
        if ($choix === "entreprise") {
            $remise = 10;
            $montantReduction = $prix * $remise / 100;
            $prixAvecReduction = $prix - $montantReduction;
        } else {
            $remise = 0;
            $montantReduction = 0;
            $prixAvecReduction = $prix;
        }

        // Enregistrer le prix dans la session
        $session->set('prix', $prixAvecReduction);

        if (!empty($this->getUser())) {
            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));
        }
        $haieCode = $doctrine->getRepository(Haie::class)->find($haie);

        $devis = new Devis();
        $devis->setUser($monUser);
        $devis->setHaie($haieCode);
        $devis->setLongueur($longueur);
        $devis->setHauteur($hauteur);
        $devis->setPrix($prixAvecReduction);
        $devis->setTypeClient($choix);
        $devis->setDate(new \DateTime());

        $entityManager->persist($devis);
        $entityManager->flush();

        // Affichez le formulaire dans votre template
        return $this->render('devis_creer/index.html.twig', [
            'controller_name' => 'DevisCreerController',
            'user' => $monUser, 'prix' => $prixAvecReduction,
        ]);
    }

}
