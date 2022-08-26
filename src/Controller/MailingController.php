<?php

namespace App\Controller;

use App\Entity\Mailing;
use App\Entity\User;
use App\Entity\Partner;
use App\Form\MailingType;
use App\Repository\MailingRepository;
use App\Repository\PartnerRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * This controller manages the mailing for the newsletters for example
 */

#[Route('/mailing')]
class MailingController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_mailing_index', methods: ['GET'])]
    public function index(MailingRepository $mailingRepository,  PaginatorInterface $paginator, Request $request): Response
    {
        $mailings = $mailingRepository->findAll();
        $mailings = $paginator->paginate(
            $mailings,


        $request->query->getInt('page', 1),
            5
        );

        return $this->render('pages/mailing/index.html.twig', [
            'mailings' => $mailings,
            //'partners' => $partnerRepository->findAll(),
        ]);
    }
//fonctionne avec l'adresse mail- voir avec la préparation de la newsletter 55min
    #[IsGranted('ROLE_USER')]
    #[Route('/new', name: 'app_mailing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailingRepository $mailingRepository, MailerInterface $mailer): Response
    {
        $mailing = new Mailing();
        $form = $this->createForm(MailingType::class, $mailing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailingRepository->add($mailing, true);

        

        $email = (new TemplatedEmail())
        //->from($mailing->getPartners())
        ->from('cyrisa02.test@gmail.com')
        ->to('cyrisa02.test@gmail.com')
        //->to($user->getEmail())
        ->subject($mailing->getTitle())

        ->text('Sending emails is fun again!');
        //->text($mailing->getPartners());
        //->htmlTemplate('emails/contact.html.twig');
        // ->context([
        //     'contact'=>$contact
        // ]);
        $mailer->send($email);

        $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );
            return $this->redirectToRoute('app_mailing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/mailing/new.html.twig', [
            'mailing' => $mailing,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_mailing_show', methods: ['GET'])]
    public function show(Mailing $mailing): Response
    {
        return $this->render('pages/mailing/show.html.twig', [
            'mailing' => $mailing,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edit', name: 'app_mailing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mailing $mailing, MailingRepository $mailingRepository, MailerInterface $mailer): Response
    {
        $form = $this->createForm(MailingType::class, $mailing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailingRepository->add($mailing, true);
            
            

            $email = (new TemplatedEmail())
        //->from($mailing->getPartners())
        ->from('cyrisa02.test@gmail.com')
        //->to('cyrisa02.test@gmail.com')
        ->to('atelier.cabriolet@gmail.com')
        ->subject($mailing->getTitle())

        ->text('Recherche de mail!');
        //->text($mailing->getPartners());
        //->htmlTemplate('emails/contact.html.twig');
        // ->context([
        //     'contact'=>$contact
        // ]);
        $mailer->send($email);

        $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );

            return $this->redirectToRoute('app_mailing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/mailing/edit.html.twig', [
            'mailing' => $mailing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mailing_delete', methods: ['POST'])]
    public function delete(Request $request, Mailing $mailing, MailingRepository $mailingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailing->getId(), $request->request->get('_token'))) {
            $mailingRepository->remove($mailing, true);
        }

        return $this->redirectToRoute('app_mailing_index', [], Response::HTTP_SEE_OTHER);
    }

     #[Route('/send/{id}', name: 'send', methods: ['GET', 'POST'])]
     public function send($id, Mailing $mailing, MailerInterface $mailer, MailingRepository $mailingRepository): Response
     {
        $mail= $mailingRepository->find($id);
        
         $user = $mail->getPartners()[0]->getUsers()[0]->getEmail();

        $email = (new TemplatedEmail())
        //->from($mailing->getPartners())
        ->from('cyrisa02.test@gmail.com')
        //->to('cyrisa02.test@gmail.com')
        ->to($user)
        ->subject($mailing->getTitle())

        ->text('Recherche de mail!');
        //->text($mailing->getPartners());
        //->htmlTemplate('emails/contact.html.twig');
        // ->context([
        //     'contact'=>$contact
        // ]);
        $mailer->send($email);

        return $this->redirectToRoute('app_mailing_index');


     }
}