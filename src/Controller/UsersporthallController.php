<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\SporthallRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * This Controller allows to link the Entity User with The Entity Sporthall
 */

#[Route('/clients_salle_de_sport')]
class UsersporthallController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_usersporthall_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, SporthallRepository $sporthallRepository,PaginatorInterface $paginator, Request $request): Response
    {

        $users = $userRepository->findAll();

        $users = $paginator->paginate(
            $users,

        $request->query->getInt('page', 1),
            3
        );
        return $this->render('pages/user/indexsporthall.html.twig', [
            'users' => $users,
            'sporthalls'=> $sporthallRepository->findAll(),
        ]);
    }
}