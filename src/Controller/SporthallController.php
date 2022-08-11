<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Sporthall;
use App\Form\SporthallType;
use App\Repository\UserRepository;
use App\Repository\SporthallRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/structure')]
class SporthallController extends AbstractController
{
     #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_sporthall_index', methods: ['GET'])]
    public function index(SporthallRepository $sporthallRepository, UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $sporthalls = $sporthallRepository->findAll();

        $sporthalls =$paginator->paginate(
            $sporthalls,
            
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('pages/sporthall/index.html.twig', [
            'sporthalls' => $sporthalls,
            'users' => $userRepository->findAll(),
        ]);
    }
    #[IsGranted('ROLE_USER')]
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

     #[IsGranted('ROLE_USER')]
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