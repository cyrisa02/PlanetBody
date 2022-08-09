<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Sporthall;
use App\Form\SporthallType;
use App\Repository\SporthallRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/structure')]
class SporthallController extends AbstractController
{
    #[Route('/', name: 'app_sporthall_index', methods: ['GET'])]
    public function index(SporthallRepository $sporthallRepository, UserRepository $userRepository): Response
    {
        return $this->render('pages/sporthall/index.html.twig', [
            'sporthalls' => $sporthallRepository->findAll(),
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/creation', name: 'app_sporthall_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SporthallRepository $sporthallRepository): Response
    {
        $sporthall = new Sporthall();
        $form = $this->createForm(SporthallType::class, $sporthall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sporthallRepository->add($sporthall, true);

            return $this->redirectToRoute('app_sporthall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sporthall/new.html.twig', [
            'sporthall' => $sporthall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sporthall_show', methods: ['GET'])]
    public function show(Sporthall $sporthall): Response
    {
        return $this->render('pages/sporthall/show.html.twig', [
            'sporthall' => $sporthall,
        ]);
    }

    #[Route('/{id}/edition', name: 'app_sporthall_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sporthall $sporthall, SporthallRepository $sporthallRepository): Response
    {
        $form = $this->createForm(SporthallType::class, $sporthall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sporthallRepository->add($sporthall, true);

            return $this->redirectToRoute('app_sporthall_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sporthall/edit.html.twig', [
            'sporthall' => $sporthall,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sporthall_delete', methods: ['POST'])]
    public function delete(Request $request, Sporthall $sporthall, SporthallRepository $sporthallRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sporthall->getId(), $request->request->get('_token'))) {
            $sporthallRepository->remove($sporthall, true);
        }

        return $this->redirectToRoute('app_sporthall_index', [], Response::HTTP_SEE_OTHER);
    }
}