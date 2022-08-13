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

#[Route('/permission')]
class PermissionController extends AbstractController
{
    #[Route('/', name: 'app_permission_index', methods: ['GET'])]
    public function index(PermissionRepository $permissionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $permissions = $permissionRepository->findAll();
        $permissions =$paginator->paginate(
            $permissions,            
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('pages/permission/index.html.twig', [
            'permissions' => $permissions,
        ]);
    }

    #[Route('/creation', name: 'app_permission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PermissionRepository $permissionRepository): Response
    {
        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $permissionRepository->add($permission, true);

            return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/permission/new.html.twig', [
            'permission' => $permission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_permission_show', methods: ['GET'])]
    public function show(Permission $permission): Response
    {
        return $this->render('pages/permission/show.html.twig', [
            'permission' => $permission,
        ]);
    }

    #[Route('/{id}/edition', name: 'app_permission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Permission $permission, PermissionRepository $permissionRepository): Response
    {
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $permissionRepository->add($permission, true);

            return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/permission/edit.html.twig', [
            'permission' => $permission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_permission_delete', methods: ['POST'])]
    public function delete(Request $request, Permission $permission, PermissionRepository $permissionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$permission->getId(), $request->request->get('_token'))) {
            $permissionRepository->remove($permission, true);
        }

        return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
    }
}