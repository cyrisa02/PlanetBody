<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/voir_permission')]
class ShowpermissionController extends AbstractController
{
    #[Route('/', name: 'app_showpermission_index', methods: ['GET'])]
    public function index(PermissionRepository $permissionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $permissions = $permissionRepository->findAll();

        $permissions =$paginator->paginate(
            $permissions,
            
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('pages/permission/indexshowpermission.html.twig', [
            'permissions' => $permissions,
        ]);
    }

}