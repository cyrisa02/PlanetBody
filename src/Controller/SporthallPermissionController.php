<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Sporthall;
use App\Entity\Permission;
use App\Form\SporthallType;
use App\Repository\UserRepository;
use App\Form\SporthallPermissionType;
use App\Repository\SporthallRepository;
use App\Repository\PermissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * The Controller allows to display the permisions for a sporthall
 */

#[Route('/structure_permission')]
class SporthallPermissionController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_sporthallpermission_index', methods: ['GET'])]
    public function index(SporthallRepository $sporthallRepository, UserRepository $userRepository, PermissionRepository $permissionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $sporthalls = $sporthallRepository->findAll();

        $sporthalls = $paginator->paginate(
            $sporthalls,
            
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('pages/sporthall/indexpermission.html.twig', [
            'sporthalls' => $sporthalls,
            'users' => $userRepository->findAll(),
            'permissions' => $permissionRepository->findAll(),
        ]);
    }


#[IsGranted('ROLE_USER')]
#[Route('/{id}/edition', name: 'app_sporthallpermission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sporthall $sporthall, SporthallRepository $sporthallRepository,MailerInterface $mailer): Response
    {
        $form = $this->createForm(SporthallPermissionType::class, $sporthall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sporthallRepository->add($sporthall, true);

             $email = (new TemplatedEmail())
        ->from('cyrisa02.test@gmail.com')
        //->to($partner->getUser()->getEmail())    à mettre en place en prod
        ->to('atelier.cabriolet@gmail.com')      
        ->subject('Votre statut mis à jour')
        ->htmlTemplate('emails/sporthallpermission.html.twig')
        ->context([
            'sporthall'=>$sporthall
        ]);
        $mailer->send($email);


            $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès!'
            );

            return $this->redirectToRoute('app_sporthallpermission_index', [], Response::HTTP_SEE_OTHER);
        }

        

        return $this->renderForm('pages/sporthall/editpermission.html.twig', [
            'sporthall' => $sporthall,
            'form' => $form,
        ]);
    }
    }