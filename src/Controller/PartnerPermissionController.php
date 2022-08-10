<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Entity\Permission;
use App\Repository\UserRepository;
use App\Form\PartnerPermissionType;
use App\Repository\PartnerRepository;
use App\Repository\PermissionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


#[Route('/franchise_permission')]
class PartnerPermissionController extends AbstractController
{
    #[Route('/', name: 'app_partnerpermission_index', methods: ['GET'])]
    public function index(PartnerRepository $partnerRepository, UserRepository $userRepository, PermissionRepository $permissionRepository): Response
    {
        return $this->render('pages/partner/indexpermission.html.twig', [
            'partners' => $partnerRepository->findAll(),
            'users' => $userRepository->findAll(),
            'permissions' => $permissionRepository->findAll(),
        ]);
    }



#[Route('/{id}/edition', name: 'app_partnerpermission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, PartnerRepository $partnerRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(PartnerPermissionType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->add($partner, true);

            $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        //->to($partner->getUser()->getEmail())  à mettre en place en prod
        ->to('atelier.cabriolet@gmail.com')      
        ->subject('Votre statut mis à jour')
        ->htmlTemplate('emails/partnerpermission.html.twig')
        ->context([
            'partner'=>$partner
        ]);
        $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès!'
            );

            return $this->redirectToRoute('app_partnerpermission_index', [], Response::HTTP_SEE_OTHER);
        }

        

        return $this->renderForm('pages/partner/editpermission.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }
    }