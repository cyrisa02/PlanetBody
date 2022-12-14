<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Partner;
use App\Repository\UserRepository;
use App\Repository\PartnerRepository;
use App\Repository\SporthallRepository;
use App\Repository\PermissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * This Controller with the method index allows to link the Entity User with The Entity Partner
 */
#[Route('/clients')]
class UserController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, PartnerRepository $partnerRepository,PaginatorInterface $paginator, Request $request): Response
    {

        $users = $userRepository->findAll();

        $users = $paginator->paginate(
            $users,

        $request->query->getInt('page', 1),
            3
        );
        return $this->render('pages/user/index.html.twig', [
            'users' => $users,
            'partners'=> $partnerRepository->findAll(),
        ]);
    }

    #[Route('/creation', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, PermissionRepository $permissionRepository, SporthallRepository $sporthallRepository, PartnerRepository $partnerRepository): Response
    {      
        
        return $this->render('pages/user/show.html.twig', [
            'user' => $user,
            'permissions' => $permissionRepository->findAll(),
            'sporthalls' => $sporthallRepository-> findAll(),
            'partners' => $partnerRepository-> findAll(),
                       
        ]);
    }

    #[Route('/{id}/edition', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}