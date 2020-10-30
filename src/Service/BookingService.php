<?php

namespace App\Service;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;


class BookingService{

    private $repo;
    private $manager;

    public function __construct( BookingRepository $repo)
    {
        $this->repo = $repo;
        
        
    }

    public function getNotAvailableDays(){
        $notavailableday=[];
        $bookings = $this->repo->findAll();

        foreach ( $bookings as $booking){
    
            foreach($booking->getPeriod() as $day){
                $notavailableday[]= $day->getDate();
            }
        }
        return $notavailableday;
        

    }
}