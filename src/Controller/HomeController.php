<?php

namespace App\Controller;

use App\Entity\User;
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
     public function index(UserRepository $userRepository): Response
     {
         return $this->render('pages/home.html.twig', [
             'controller_name' => 'HomeController',
             'users' =>
            $userRepository->findAll(),
             
            
         ]);
     }


}