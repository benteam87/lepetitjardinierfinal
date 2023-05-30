<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Devis;
use App\Entity\User;
use App\Entity\Haie;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class DevisCreerController extends AbstractController
{
    #[Route('/devis/creer', name: 'app_devis_creer')]
    public function index(ManagerRegistry $doctrine, SessionInterface $session, Request $request): Response
    {
        $request = Request::createFromGlobals();

        $entityManager = $doctrine->getManager();

        $choix = $session->get('choix');             // On utilise les get pour obtenir les données de l'id de l'input voulue
        $haie = $session->get('haie');
        $hauteur = $session->get('hauteur');
        $longueur = $session->get('longueur');

        if (!empty($this->getUser())) {
            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));

            $typeClient = $monUser->getTypeClient();
        } else {
            $typeClient = '';
        }

        try {
            $codehaie = $doctrine->getRepository(Haie::class)->find($haie);
        } catch (\Exception $e) {
            var_dump($haie);
            // Autres actions de gestion de l'erreur si nécessaire
        }

        $devis = new Devis();
//        $devis->setUser($monUser);
//        $devis->setHaie($codehaie);
        $devis->setLongueur($longueur);
        $devis->setHauteur($hauteur);
        $devis->setDate(new \DateTime());

        $entityManager->persist($devis);
        $entityManager->flush();


        return $this->render('creation_devis/index.html.twig', [
            'controller_name' => 'CreationDevisController',
            'user' => $monUser,
        ]);
    }
}
