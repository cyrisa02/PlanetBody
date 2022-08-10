<?php

namespace App\Controller;

use App\Entity\Claim;
use App\Form\ClaimType;

//use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClaimController extends AbstractController
{
    #[Route('/demande_info', name: 'app_claim')]
    public function index(Request $request,
    EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $claim = new Claim();
        $form = $this->createForm(ClaimType::class, $claim);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $claim = $form->getData();

            $email = (new TemplatedEmail())
        ->from($claim->getEmail())
        ->to('cyrisa02.test@gmail.com')
        //addTo('ajouterunenvelleadresse@gmail.com)
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com') si on veut une autre adresse de réception des réponse
        //->priority(Email::PRIORITY_HIGH)
        
        ->subject($claim->getSubject())
        ->htmlTemplate('emails/claim.html.twig')
        ->context([
            'claim'=>$claim
        ]);
        //->html($contact->getMessage());



        $mailer->send($email);

            $manager->persist($claim);

            $manager->flush();

            $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );
        

        return $this->redirectToRoute('app_claim');
    }

    return $this->render('pages/claim/index.html.twig', [
        'form'=> $form->createView(),
    ]);
    }
}