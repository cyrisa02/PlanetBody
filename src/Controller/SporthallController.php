<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Sporthall;
use App\Form\SporthallType;
use App\Repository\UserRepository;
use App\Repository\SporthallRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This controller manages the CRUD for the sporthalls
 */

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
            1
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
        $this->addFlash(
                'success',
                'Votre demande a été supprimée avec succès'
            );
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
    public function edit(Request $request, Sporthall $sporthall, SporthallRepository $sporthallRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(SporthallType::class, $sporthall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sporthallRepository->add($sporthall, true);
            $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        //->to($partner->getUser()->getEmail())    à mettre en place en prod
        ->to('atelier.cabriolet@gmail.com')      
        ->subject('Votre statut mis à jour')
        ->htmlTemplate('emails/sporthallenable.html.twig')
        ->context([
            'sporthall'=>$sporthall
        ]);
        $mailer->send($email);

        $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );

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