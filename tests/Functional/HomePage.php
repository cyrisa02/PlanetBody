<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePage extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        $button = $crawler->filter('btn btn-primary btn-lg');
        $this->assertEquals(1, count($button));
        $this->assertSelectorTextContains('h1', 'PlanetBody');
    }
}