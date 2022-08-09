<?php

namespace App\Controller;

use App\Entity\Sentmail;
use App\Form\SentmailType;
use App\Repository\SentmailRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/sentmail')]
class SentmailController extends AbstractController
{
    #[Route('/', name: 'app_sentmail_index', methods: ['GET'])]
    public function index(SentmailRepository $sentmailRepository): Response
    {
        return $this->render('pages/sentmail/index.html.twig', [
            'sentmails' => $sentmailRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sentmail_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SentmailRepository $sentmailRepository): Response
    {
        $sentmail = new Sentmail();
        $form = $this->createForm(SentmailType::class, $sentmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sentmailRepository->add($sentmail, true);

            return $this->redirectToRoute('app_sentmail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sentmail/new.html.twig', [
            'sentmail' => $sentmail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sentmail_show', methods: ['GET'])]
    public function show(Sentmail $sentmail): Response
    {
        return $this->render('pages/sentmail/show.html.twig', [
            'sentmail' => $sentmail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sentmail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sentmail $sentmail, SentmailRepository $sentmailRepository): Response
    {
        $form = $this->createForm(SentmailType::class, $sentmail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sentmailRepository->add($sentmail, true);

            return $this->redirectToRoute('app_sentmail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sentmail/edit.html.twig', [
            'sentmail' => $sentmail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sentmail_delete', methods: ['POST'])]
    public function delete(Request $request, Sentmail $sentmail, SentmailRepository $sentmailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sentmail->getId(), $request->request->get('_token'))) {
            $sentmailRepository->remove($sentmail, true);
        }

        return $this->redirectToRoute('app_sentmail_index', [], Response::HTTP_SEE_OTHER);
    }

#[Route('/send/{id}', name: 'send', methods: ['GET', 'POST'])]
    public function send(Sentmail $sentmail, MailerInterface $mailer): Response
    {
        $toemail = $sentmail->getUsers()->getEmail();

        $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        ->to($toemail)
        ->subject($sentmail->getMailings()->getTitle())
        ->text('Sending emails is fun again!');
        $mailer->send($email);
   
    return $this->redirectToRoute('app_mailing_index');
    }

}