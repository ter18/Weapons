<?php

namespace App\DataFixtures;

use App\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class WeaponFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('it_IT');

        for($i = 0; $i < 100; $i++){
            $weapon = new Weapon();
            $weapon
                ->setName($faker->name)
                ->setCreatedAt($faker->dateTime($max = 'now', $timezone = 'Europe/Brussels'))
                ->setPower($faker->numberBetween(1,2))
                ->setDescription($faker->text)
                ;
                $manager->persist($weapon);

        }

        $manager->flush();
    }
}
