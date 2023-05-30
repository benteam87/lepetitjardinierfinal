<?php

namespace App\Controller;

use App\Entity\Haie;
use App\Form\HaieType;
use App\Repository\HaieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/haie')]
class HaieController extends AbstractController
{
    #[Route('/', name: 'app_haie_index', methods: ['GET'])]
    public function index(HaieRepository $haieRepository): Response
    {
        return $this->render('haie/index.html.twig', [
            'haies' => $haieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_haie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HaieRepository $haieRepository): Response
    {
        $haie = new Haie();
        $form = $this->createForm(HaieType::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $haieRepository->save($haie, true);

            return $this->redirectToRoute('app_haie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('haie/new.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{code}', name: 'app_haie_show', methods: ['GET'])]
    public function show(Haie $haie): Response
    {
        return $this->render('haie/show.html.twig', [
            'haie' => $haie,
        ]);
    }

    #[Route('/{code}/edit', name: 'app_haie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Haie $haie, HaieRepository $haieRepository): Response
    {
        $form = $this->createForm(HaieType::class, $haie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $haieRepository->save($haie, true);

            return $this->redirectToRoute('app_haie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('haie/edit.html.twig', [
            'haie' => $haie,
            'form' => $form,
        ]);
    }

    #[Route('/{code}', name: 'app_haie_delete', methods: ['POST'])]
    public function delete(Request $request, Haie $haie, HaieRepository $haieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$haie->getCode(), $request->request->get('_token'))) {
            $haieRepository->remove($haie, true);
        }

        return $this->redirectToRoute('app_haie_index', [], Response::HTTP_SEE_OTHER);
    }
}
