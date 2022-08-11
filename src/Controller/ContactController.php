<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/preinscription')]
class ContactController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    public function index(ContactRepository $contactRepository,  PaginatorInterface $paginator, Request $request): Response
    {
        $contacts = $contactRepository->findAll();

        $contacts = $paginator->paginate(
            $contacts,
            
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('pages/contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/creation', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContactRepository $contactRepository,MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }
        $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        //->to($contact->getEmail())  fonctionne très bien, dévalider la ligne 65 et valider la 64
        ->to('atelier.cabriolet@gmail.com')      
        //->subject($contact->getSubject())
        ->htmlTemplate('emails/contactanswercreate.html.twig')
        ->context([
            'contact'=>$contact
        ]);
        $mailer->send($email);

        $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );

             return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        
        return $this->renderForm('pages/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        return $this->render('pages/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edition', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        //->to($contact->getEmail())  fonctionne très bien, dévalider la ligne 65 et valider la 64
        ->to('atelier.cabriolet@gmail.com')      
        ->subject($contact->getSubject())
        ->htmlTemplate('emails/contactansweredit.html.twig')
        ->context([
            'contact'=>$contact
        ]);
        $mailer->send($email);

        $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );
            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact, true);
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}