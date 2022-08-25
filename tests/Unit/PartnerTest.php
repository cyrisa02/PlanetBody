<?php

namespace App\Tests\Unit;

use App\Entity\Partner;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PartnerTest extends KernelTestCase
{
    public function testPartnerIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $partner = new Partner();
        $partner->setContract('Contrat1')
                ->setIsEnable(true);

        $errors = $container->get('validator')->validate($partner);

        $this->assertCount(0, $errors);
       
    }

    public function testInvalidName(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $partner = new Partner();
        $partner->setContract('')
                ->setIsEnable(true);

        $errors = $container->get('validator')->validate($partner);

        $this->assertCount(0, $errors);
       
    }

    public function testInvalidBoolean(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $partner = new Partner();
        $partner->setContract('Contrat1')
                ->setIsEnable('not');

        $errors = $container->get('validator')->validate($partner);

        $this->assertCount(0, $errors);
       
    }
}