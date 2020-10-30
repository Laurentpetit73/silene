<?php

namespace App\DataFixtures;

use App\Entity\Calendar;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CalendarFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['group2'];
    }

    public function load(ObjectManager $manager)
    {
        $date= new \DateTime('2020-01-01');
        $interval = new \DateInterval('P1D');

        $month = ['01'=> ['Janvier','Janv'],
                '02'=> ['Février','Fév'],
                '03'=> ['Mars','Mars'],
                '04'=> ['Avril','Avril'],
                '05'=> ['Mai','Mai'],
                '06'=> ['Juin','Juin'],
                '07'=> ['Juillet','Juil'],
                '08'=> ['Aôut','Aôut'],
                '09'=> ['Septembre','Sept'],
                '10'=> ['Octobre','Oct'],
                '11'=> ['Novembre','Nov'],
                '12'=> ['Décembre','Déc'],
        ];
        $day = [['Dimanche','Dim'],
                ['Lundi','Lun'],
                ['Mardi','Mar'],
                ['Mercredi','Mer'],
                ['Jeudi','Jeu'],
                ['Vendredi','Ven'],
                ['Samedi','Sam']
        ];

        for($i=0 ; $i<=1000 ;$i++){
            
            $calendar = new Calendar();
            $calendar->setDateKey($date->format('Ymd'))
                    ->setDate(clone $date)
                    ->setDay($date->format('d'))
                    ->setMonth($date->format('m'))
                    ->setYear($date->format('Y'))
                    ->setDayName($day[$date->format('w')][0])
                    ->setDayNameMin($day[$date->format('w')][1])
                    ->setMonthName($month[$date->format('m')][0])
                    ->setMonthNameMin($month[$date->format('m')][1])
                    ->setDayOfWeek($date->format('w'))
                    ->setPrice(200);
            $date->add($interval);
            $manager->persist($calendar);

        }
        $manager->flush();
    }
}
