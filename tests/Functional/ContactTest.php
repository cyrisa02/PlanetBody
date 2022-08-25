<?php

namespace App\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ContactTest extends WebTestCase
{
    public function testIfSubmittContactFormIsSuccessfull(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/contact');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Formulaire de Pré-Inscription d\'un Franchisé');

        //Récupérer le formulaire avec le bouton submit
        $submitButton = $crawler->selectButton('Soumettre ma demande');
        $form = $submitButton->form();

        $form["contact_partner[fullname]"] = "John Doe";
        $form["contact_partner[email]"] = "johndoe@gmail.com";
        $form["contact_partner[subject]"] = "Nom de la société";
        $form["contact_partner[message]"] = "Message";

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifier le statu HTTP 302 = il y une redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        // Vérifier l'envoie du mail
        $this->assertEmailCount(1);

        $client->followRedirect();

        // Vérifier la présence du message de succès
        $this->assertSelectorTextContains(
            'div.alert.alert-success.mt-4',
            'Votre demande a été enregistrée avec succès'
        );
    }
}








   