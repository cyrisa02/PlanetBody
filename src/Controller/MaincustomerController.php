<?php

namespace App\Controller;

use App\Entity\Maincustomer;
use App\Form\MaincustomerType;
use App\Repository\MaincustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * This controller manages the CRUD for the main Customer. Now it is not necessary because there is only one Amdin. In the future we can think we can create many Role Admin. So this controller will be necessary.
 */

#[Route('/client')]
class MaincustomerController extends AbstractController
{
    #[Route('/', name: 'app_maincustomer_index', methods: ['GET'])]
    public function index(MaincustomerRepository $maincustomerRepository): Response
    {
        return $this->render('pages/maincustomer/index.html.twig', [
            'maincustomers' => $maincustomerRepository->findAll(),
        ]);
    }

    #[Route('/creation', name: 'app_maincustomer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MaincustomerRepository $maincustomerRepository): Response
    {
        $maincustomer = new Maincustomer();
        $form = $this->createForm(MaincustomerType::class, $maincustomer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maincustomerRepository->add($maincustomer, true);

            return $this->redirectToRoute('app_maincustomer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/maincustomer/new.html.twig', [
            'maincustomer' => $maincustomer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maincustomer_show', methods: ['GET'])]
    public function show(Maincustomer $maincustomer): Response
    {
        return $this->render('pages/maincustomer/show.html.twig', [
            'maincustomer' => $maincustomer,
        ]);
    }

    #[Route('/{id}/edition', name: 'app_maincustomer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Maincustomer $maincustomer, MaincustomerRepository $maincustomerRepository): Response
    {
        $form = $this->createForm(MaincustomerType::class, $maincustomer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maincustomerRepository->add($maincustomer, true);

            return $this->redirectToRoute('app_maincustomer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/maincustomer/edit.html.twig', [
            'maincustomer' => $maincustomer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_maincustomer_delete', methods: ['POST'])]
    public function delete(Request $request, Maincustomer $maincustomer, MaincustomerRepository $maincustomerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maincustomer->getId(), $request->request->get('_token'))) {
            $maincustomerRepository->remove($maincustomer, true);
        }

        return $this->redirectToRoute('app_maincustomer_index', [], Response::HTTP_SEE_OTHER);
    }
}