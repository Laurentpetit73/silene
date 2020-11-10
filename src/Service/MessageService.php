<?php

namespace App\Service;
use App\Entity\Booking;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;


class MessageService{

    private $manager;
    private $booking;

    public function __construct(EntityManagerInterface $manager, Booking $booking)
    {
        $this->manager = $manager; 
        $this->booking = $booking; 
    }

    private function sendMessage(string $content,bool $admin){

        $message = new Message();
        $message->setContent($content)->setIsAdmin($admin);
        $message->setBooking($this->booking);
        $this->manager->persist($message);

    }

    public function sendWelcomeMessage(){
        $content = "Bonjour {$this->booking->getCustomer()->getFullName()}, <br><br>
        Merci de l'attention que vous me portez à notre chalet. <br>
        Votre Résevation du {$this->booking->getStartDate()->format('d/m/Y')} au {$this->booking->getEndDate()->format('d/m/Y')} a bien été pris en compte. <br>
        Nous verifions au plus vite nos disponiblité, merci d'attendre notre acception afin de pouvoir procéder au paiement <br><br>
        Cordialement ";
        $this->sendMessage($content,true);
        return $this;

    }

    public function sendCustomerMessage(Message $message){
        $message->setIsAdmin(false);
        $message->setBooking($this->booking);
        $this->manager->persist($message);
        $this->manager->flush();
        return $this;

    }

    public function sendConfirmPaymentMessage(){
        $content = "Votre paiment a bien été effectué";
        $this->sendMessage($content,true);
        return $this;

    }

    
    

    
    
    
}