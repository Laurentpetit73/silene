<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Sample\CaptureIntentExamples\CreateOrder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaypalController extends AbstractController
{
    /**
     * @Route("/paypal/{id}", name="paypal")
     */
    public function index(Booking $booking)
    {
        $payment = new CreateOrder();
        $json = json_encode($payment->createOrder(false,$booking)->result);
        

        return $this->render('paypal/index.html.twig', [
            'payment' => $json,
        ]);
    }
     /**
     * @Route("/paypal/validate/{id}", name="paypal_validate")
     */
    public function validate(Booking $booking, EntityManagerInterface $manager)
    {
       $booking->setIsPay(true);
       $manager->persist($booking);
       $manager->flush();
        

        return $this->redirectToRoute('account_bookings',['id'=> $booking->getId()]);
    }
}
