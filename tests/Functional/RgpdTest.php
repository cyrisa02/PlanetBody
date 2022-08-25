<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RgpdTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/rgpd');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Les informations recueillies ');
    }
}