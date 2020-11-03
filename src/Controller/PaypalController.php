<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaypalController extends AbstractController
{
    /**
     * @Route("/paypal/{id}", name="paypal")
     */
    public function index()
    {
        $test = ['laurent' => 'petit'];
        $test2 = json_encode($test);
        return $this->render('paypal/index.html.twig', [
            'test' => $test2,
        ]);
    }
}
