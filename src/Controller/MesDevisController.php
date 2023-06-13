<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesDevisController extends AbstractController
{
    #[Route('/mesdevis', name: 'app_mes_devis')]
    public function index(Request $request, DevisRepository $devisRepository): Response
    {
        $devis = new Devis();
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $devisRepository->save($devis, true);
            $devis->setDate(new \DateTime());

            return $this->redirectToRoute('app_mes_devis', [], Response::HTTP_SEE_OTHER);
        }

        $devisListe = $devisRepository->findBy(['user' => $this->getUser()]);


        return $this->render('mes_devis/index.html.twig', [
            'controller_name' => 'MesDevisController', 'devisListe' => $devisListe
        ]);
    }
}
