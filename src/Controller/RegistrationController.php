<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\Partner;
use App\Entity\Sporthall;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RegistrationFormTypePartner;
use App\Form\RegistrationFormTypeSporthall;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription_partner', name: 'app_register_partner')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormTypePartner::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // incrémentation de sa clé primaire du partenaire
            $partner = new Partner();
            // Coàntrat est un champ texte à remplir gràace au formulaire
            $partner->setContract($form->get('contract')->getData())
            // à 0 parce que je veux qu'il soit à false donc 0
                    ->setIsEnable(0);

            //vient chercher la clé étrangère  ne pas oublier de persister       
            $user->setPartners($partner);        
            
            // encode the plain password
            $user->setRoles(["ROLE_PARTNER"])
            
            ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //Important pour la relation OneToOne - Héritage
            $entityManager->persist($partner);
            $entityManager->persist($user);

            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register_partner.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

         #[Route('/inscription_sporthall', name: 'app_register_sporthall')]
    public function register2(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormTypeSporthall::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // incrémentation de sa clé primaire du partenaire
            $sporthall = new Sporthall();
            // Coàntrat est un champ texte à remplir gràace au formulaire
            $sporthall ->setIsEnable(0);
            // à 0 parce que je veux qu'il soit à false donc 0
                   

            //vient chercher la clé étrangère       ne pas oublier de persister   
            $user->setSporthalls($sporthall);   
             $user->setRoles(["ROLE_SPORTHALL"])
            // encode the plain password
            ->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //Important pour la relation OneToOne - Héritage
            $entityManager->persist($sporthall);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            $this->addFlash(
                'success',
                'Votre demande a été enregistrée avec succès'
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register_sporthall.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}