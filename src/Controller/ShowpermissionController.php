<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/showpermission')]
class ShowpermissionController extends AbstractController
{
    #[Route('/', name: 'app_showpermission_index', methods: ['GET'])]
    public function index(PermissionRepository $permissionRepository): Response
    {
        return $this->render('pages/permission/indexshowpermission.html.twig', [
            'permissions' => $permissionRepository->findAll(),
        ]);
    }

}