<?php

namespace App\Tests\Functional;

use App\Entity\User;
use App\Entity\Partner;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartnerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        // Récupérer l'urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        // Récup entity manager, il faut être connecté , 15=admin

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 15);

        $client->loginUser($user);

        // Se rendre sur la page de création d'un franchisé
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_register_partner') );

        // Gérer le formulaire
        $form = $crawler->filter("form[name=registration_form_type_partner]")->form([
            'registration_form_type_partner[name]' => "Société",
            'registration_form_type_partner[contact]' => "John Doe",
            'registration_form_type_partner[contract]' => "Blue-Société",
            'registration_form_type_partner[address]' => "27 rue des Lilas",
            'registration_form_type_partner[zipcode]' => "02200",
            'registration_form_type_partner[city]' => "Soissons",
            'registration_form_type_partner[email]' => "johndoe@gmail.com",
            'registration_form_type_partner[plainPassword]' => "azertyui",
            'registration_form_type_partner[agreeTerms]' => True,
        ]);
        $client->submit($form);

        //Gérer la redirection

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        // Gérer l'alert box
        $this->assertSelectorTextContains('div.alert-success', 'Votre demande a été enregistrée avec succès');

        $this->assertRouteSame('home_index');

        // Bien vérifier que le token du formulaire est bien dans les balises form grâce à l'insspecteur du navigateur        
    }

    public function testIfListPartnerIsSuccessfull(): void
    {
        $client = static::createClient();

        // Récupérer l'urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        // Récup entity manager, il faut être connecté , 15=admin

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 15);

        $client->loginUser($user);

        // Se rendre sur la page de création d'un franchisé
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_partner_index') );

        $this->assertResponseIsSuccessful();

        $this->assertRouteSame('app_partner_index');
    }

    public function testIfUpdateAnParnterIsSuccessfull(): void
    {
        $client = static::createClient();
        
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 15);
        $partner = $entityManager->find(Partner::class, 7);

        $client->loginUser($user);
        
        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('app_partner_edit', [7])
        );

     
        $this->assertResponseIsSuccessful();

        $form = $crawler->filter('form[name=partner]')->form([
            'partner[contract]'=>"Velvet - Tanguy",
            'partner[user]'=>"rleclerc@barre.com",
            'partner[is_enable]'=> false,
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        // Gérer l'alert box
        $this->assertSelectorTextContains('div.alert-success', 'Votre demande a été enregistrée avec succès');

        $this->assertRouteSame('app_partner_index');
    }

    public function testIfDeleteAnIngredientIsSuccessfull(): void

    {
        $client = static::createClient();
        
        $urlGenerator = $client->getContainer()->get('router');

        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

        $user = $entityManager->find(User::class, 15);
        $partner = $entityManager->find(Partner::class, 7);

        $client->loginUser($user);
        
        $crawler = $client->request(
            Request::METHOD_GET,
            $urlGenerator->generate('app_partner_delete', [7])
        );     
       
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();

        // Gérer l'alert box
        $this->assertSelectorTextContains('div.alert-success', 'Votre demande a été supprimée avec succès');

        $this->assertRouteSame('app_partner_index');

    }


}