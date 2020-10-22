<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminAccountController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_login")
     */
    public function index()
    {


        return $this->render('admin/account/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
