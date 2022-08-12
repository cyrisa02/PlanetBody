<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;

/**
 * This controller displays the HomepPage 
 */
class HomeController extends AbstractController
{
    //  #[Route('/', name: 'home.index')]
    //  public function index(): Response
    //  {
    //      return $this->render('pages/home.html.twig', [
    //          'controller_name' => 'HomeController',
             
            
    //      ]);
    //  }

 #[Route('/', name: 'home.index', methods: ['GET'])]
     public function index(UserRepository $userRepository, Request $request): Response
     {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

         return $this->render('pages/home.html.twig', [
            
            'users' =>             $userRepository->findAll(),
            
             'form' => $form->createView(),
         ]);
     }

}