<?php

namespace App\Controller;

use Sample\CaptureIntentExamples\CreateOrder;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaypalController extends AbstractController
{
    /**
     * @Route("/paypal/", name="paypal")
     */
    public function index()
    {
        $payment = new CreateOrder();
        $json = json_encode($payment->createOrder()->result);

        return $this->render('paypal/index.html.twig', [
            'payment' => $json,
        ]);
    }
}
