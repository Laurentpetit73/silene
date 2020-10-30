<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Booking;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    private $passwordEncoder;
    private $manage;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manage)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->manage = $manage;
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }

    public function load(ObjectManager $manager )
    {
        $admin = new User();
        $admin->setLastName('Petit')
                ->setFirstName('Laurent')
                ->setEmail('petit.laurent73@gmail.com')
                ->setPassword($this->passwordEncoder->encodePassword($admin,'Laurent73'))
                ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        

        $faker = Factory::create('fr_FR');

        for($i=0;$i<mt_rand(15,20);$i++){
            $user = new User();
            $user->setLastName($faker->lastName)
                    ->setFirstName($faker->firstName())
                    ->setEmail($faker->Email)
                    ->setPassword($this->passwordEncoder->encodePassword($user,'Laurent73'));
            $manager->persist($user);
            for($j=0;$j<mt_rand(1,3);$j++){
                $booking = new Booking($manager);
                $sd=$faker->dateTimeBetween('now', '+1 years');
                $add = mt_rand(2,15);
                $se=(clone $sd)->modify("+$add days");

                $booking->setStartDate($sd)
                    ->setEndDate($se)
                    ->setCustomer($user);
            
                $manager->persist($booking);
            }

        }
        $manager->flush();
    }
}
