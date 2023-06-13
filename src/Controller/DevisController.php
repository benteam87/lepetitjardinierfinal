<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Haie;
use App\Entity\User;
use App\Entity\Devis;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class DevisController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/devis', name: 'app_devis')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $request = Request::createFromGlobals();
        $haie = $request->get('haie');
        $hauteur = $request->get('hauteur');
        $longueur = $request->get('longueur');

        if (!empty($this->getUser())) {
            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));
        }

        $session = new Session();
        $choix = $session->get('choix');
        $session->set('monUser', $monUser);
        $session->set('haie', $haie);
        $session->set('hauteur', $hauteur);
        $session->set('longueur', $longueur);

        $prix = $doctrine->getRepository(Haie::class)->find($haie)->getPrix();
        $session->set('prix', $prix);
        $maHaie = $doctrine->getRepository(Haie::class)->find($haie);


        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'haie' => $haie, 'hauteur' => $hauteur, 'longueur' => $longueur, 'choix' => $choix, 'prix' =>$prix,
            'maHaie' => $maHaie, 'monUser' => $monUser
        ]);
    }


    public function create(Request $request, SessionInterface $session)
    {

// Récupérer les informations du devis depuis la requête
        $informationsDevis = $request->get('informations_devis');


// Passer les informations au devisCreerController
        return $this->redirectToRoute('app_devis_creer', ['informationsDevis' => $informationsDevis]);

    }


}
