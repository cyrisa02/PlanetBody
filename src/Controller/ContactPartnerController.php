<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactPartnerType;

//use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class ContactPartnerController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,
    EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactPartnerType::class, $contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $email = (new TemplatedEmail())
        ->from($contact->getEmail())
        
        ->to('cyrisa02.test@gmail.com')
        //addTo('ajouterunenvelleadresse@gmail.com)
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com') si on veut une autre adresse de réception des réponse
        //->priority(Email::PRIORITY_HIGH)
        
        ->subject($contact->getSubject())
        ->htmlTemplate('emails/contact.html.twig')
        ->context([
            'contact'=>$contact
        ]);
        //->html($contact->getMessage());



        $mailer->send($email);

            $manager->persist($contact);

            $manager->flush();

            $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );
        

        return $this->redirectToRoute('app_contact');
    }

    return $this->render('pages/contact/indexpartner.html.twig', [
        'form'=> $form->createView(),
    ]);
    }
}