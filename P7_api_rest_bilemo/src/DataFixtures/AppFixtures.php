<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\ProductFactory;
use App\Factory\BrandFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        BrandFactory::new()->createMany(10);
        ProductFactory::new()->createMany(25, function(){return ['brand' => BrandFactory::random()];
        });

        $manager->flush();
    }
}
