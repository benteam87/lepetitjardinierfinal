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
use App\Entity\Devis;
use Doctrine\ORM\EntityManagerInterface;

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

        $session = new Session();
        $choix = $session->get('choix');

        $prix = $doctrine->getRepository(Haie::class)->find($haie)->getPrix();
        $maHaie = $doctrine->getRepository(Haie::class)->find($haie);


        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'haie' => $haie, 'hauteur' => $hauteur, 'longueur' => $longueur, 'choix' => $choix, 'prix' =>$prix,
            'maHaie' => $maHaie,
        ]);
    }


}
