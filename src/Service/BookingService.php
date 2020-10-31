<?php

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;


class BookingService{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;  
    }

    
    public function getNotConfirmBooking(){
        return $this->manager->createQuery(
            'SELECT  b
            FROM App\Entity\Booking b
            WHERE b.IsBooking = 0')
            ->getResult();
    }

    public function getNotAvailableDays(){
        $notavailableday=[];
        $days =  $this->manager->createQuery(
            'SELECT  c
            FROM App\Entity\Calendar c
            WHERE c.booking IS NOT NULL')
            ->getResult();

        foreach ( $days as $day){
            $notavailableday[]= $day->getDate();
        }

        return $notavailableday;    

    }

    public function getNotAvailableDaysEnd(){
        $notavailableday=[];
        $days =  $this->manager->createQuery(
            'SELECT  c
            FROM App\Entity\Calendar c
            WHERE c.booking IS NOT NULL AND c.isStart = 0')
            ->getResult();

        foreach ( $days as $day){
            $notavailableday[]= $day->getDate();
        }

        return $notavailableday;    

    }
    
}