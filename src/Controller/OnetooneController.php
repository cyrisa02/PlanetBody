<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OnetooneController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/onetoone', name: 'app_onetoone', methods: ['GET', 'POST'])]
    public function oneToOne(): Response
    {
        $partner = new User();
        $this->entityManager->persist($partner);

        $newUser = new User();
        $newUser->setPartners($partner);
        $this->entityManager->persist($newUser);

        $this->entityManager->flush();

        return new Response(sprintf('Franchisé crée avec id %d et nouvel utilisateur crée avec id %d',
         $partner->getId(), $newUser->getId()));

    }
}