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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * This controller allows to see the partner with his permissions
 */


#[Route('/franchise_permission')]
class PartnerPermissionController extends AbstractController
{
     #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_partnerpermission_index', methods: ['GET'])]
    public function index(PartnerRepository $partnerRepository, UserRepository $userRepository, PermissionRepository $permissionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $partners = $partnerRepository->findAll();

        $partners =$paginator->paginate(
            $partners,
            
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('pages/partner/indexpermission.html.twig', [
            'partners' => $partners, 
            'users' => $userRepository->findAll(),
            'permissions' => $permissionRepository->findAll(),
        ]);
    }


 #[IsGranted('ROLE_USER')]
#[Route('/{id}/edition', name: 'app_partnerpermission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, PartnerRepository $partnerRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(PartnerPermissionType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->add($partner, true);

            $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        //->to($partner->getUser()->getEmail())  ?? mettre en place en prod
        ->to('atelier.cabriolet@gmail.com')      
        ->subject('Votre statut mis ?? jour')
        ->htmlTemplate('emails/partnerpermission.html.twig')
        ->context([
            'partner'=>$partner
        ]);
        $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre demande a ??t?? enregistr??e avec succ??s!'
            );

            return $this->redirectToRoute('app_partnerpermission_index', [], Response::HTTP_SEE_OTHER);
        }

        

        return $this->renderForm('pages/partner/editpermission.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }
    }