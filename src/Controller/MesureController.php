<?php

namespace App\Controller;

use App\Entity\Haie;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MesureController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/mesure', name: 'app_mesure')]
    public function index(ManagerRegistry $doctrine): Response //On injecte la bibliothèque
    {
        $request = Request::createFromGlobals();
        $choix=$request->get('btn-radio');

        $session = new Session();
        $session->set('choix', $choix);

        // On veut récupérer toutes les haies
        $lesHaies = $doctrine
            ->getRepository(Haie::class)
            ->findAll();

        return $this->render('mesure/index.html.twig', [
            'controller_name' => 'MesureController', 'lesHaies' => $lesHaies,
        ]);
    }
}
