<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Service\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Sample\CaptureIntentExamples\CreateOrder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaypalController extends AbstractController
{
    /**
     * @Route("/paypal/{id}", name="paypal")
     */
    public function index(Booking $booking,EntityManagerInterface $manager)
    {
        $payment = new CreateOrder();

        $order = $payment->createOrder(false,$booking)->result;
        $id = $order->id;
        $json = json_encode($order);

        $booking->setPaypalId($id);
        $manager->persist($booking);
        $manager->flush();
        

        return $this->render('paypal/index.html.twig', [
            'payment' => $json,
        ]);
    }

     /**
     * @Route("/paypal/validate/{id}/{paypalid}", name="paypal_validate")
     */
    public function validate(Booking $booking, string $paypalid='', EntityManagerInterface $manager)
    {
        if($paypalid == $booking->getPaypalId()){
            $messageService = new MessageService($manager,$booking);
            $messageService->sendConfirmPaymentMessage();
            
            $booking->setIsPay(true);
            $manager->persist($booking);
            $manager->flush();
        }else{
            $this->addFlash('danger',"Il y eu un probleme veuillez nous contacter avant de réefectuer un paiement");
            $this->redirectToRoute('account_bookings',['id'=> $booking->getId()]);
        }

        return $this->redirectToRoute('account_bookings',['id'=> $booking->getId()]);
    }
}
