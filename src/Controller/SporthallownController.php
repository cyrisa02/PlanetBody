<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Sporthall;
use App\Form\SporthallType;
use App\Repository\UserRepository;
use App\Repository\PartnerRepository;
use App\Repository\SporthallRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * This Controller allows to show his Sporthalls for one logged Partner 
 */

#[Route('/mes_structure')]
class SporthallownController extends AbstractController
{
     #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_ownsporthall_index', methods: ['GET'])]
    public function index(SporthallRepository $sporthallRepository, UserRepository $userRepository, PaginatorInterface $paginator, Request $request, PartnerRepository $partnerRepository): Response
    {

        $sporthalls = $sporthallRepository->findAll();

        $sporthalls =$paginator->paginate(
            $sporthalls,
            
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('pages/sporthall/ownindex.html.twig', [
            'sporthalls' => $sporthalls,
            'users' => $userRepository->findAll(),
            'partners' => $partnerRepository->findAll(),
        ]);
    }
   
}