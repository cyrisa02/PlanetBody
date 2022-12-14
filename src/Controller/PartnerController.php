<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\UserRepository;
use App\Repository\PartnerRepository;
use App\Repository\SporthallRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * This controller manages the CRUD by the partners.
 */

#[Route('/franchise')]
class PartnerController extends AbstractController
{
     #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_partner_index', methods: ['GET'])]
    public function index(PartnerRepository $partnerRepository, UserRepository $userRepository,PaginatorInterface $paginator, Request $request, SporthallRepository $sporthallRepository): Response
    {
        $partners = $partnerRepository->findAll();

        $partners = $paginator->paginate(
            $partners,

        $request->query->getInt('page', 1),
            3
        );

        return $this->render('pages/partner/index.html.twig', [
            'partners' => $partners,
            'users' => $userRepository->findAll(),
            'sporthalls' => $sporthallRepository->findAll(),
        ]);
    }
    #[IsGranted('ROLE_USER')]
    #[Route('/creation', name: 'app_partner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PartnerRepository $partnerRepository): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->add($partner, true);

            return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/partner/new.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_partner_show', methods: ['GET'])]
    public function show(Partner $partner): Response
    {
        return $this->render('pages/partner/show.html.twig', [
            'partner' => $partner,
        ]);
    }

     #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edition', name: 'app_partner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, PartnerRepository $partnerRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->add($partner, true);

            $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        //->to($partner->getUser()->getEmail())    ?? mettre en place en prod
        ->to('atelier.cabriolet@gmail.com')      
        ->subject('Votre statut mis ?? jour')
        ->htmlTemplate('emails/partnerenable.html.twig')
        ->context([
            'partner'=>$partner
        ]);
        $mailer->send($email);

        $this->addFlash(
                'success',
                'Votre demande a ??t?? enregistr??e avec succ??s'
            );
            return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/partner/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $partnerRepository->remove($partner, true);
        }
        $this->addFlash(
                'success',
                'Votre demande a ??t?? supprim??e avec succ??s'
            );
            

        return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
    }
}