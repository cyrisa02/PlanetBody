<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Sporthall;
use App\Repository\PartnerRepository;
use App\Repository\SporthallRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * This controller displays the HomepPage 
 */
class HomeController extends AbstractController
{
     #[Route('/', name: 'home.index')]
     public function index(UserRepository $userRepository, SporthallRepository $sporthallRepository, PartnerRepository $partnerRepository): Response
     {
         return $this->render('pages/home.html.twig', [
             'controller_name' => 'HomeController',
             'users' =>
            $userRepository->findAll(),
            $sporthallRepository->findAll(),
            $partnerRepository->findAll(),
             
            
         ]);
     }


}