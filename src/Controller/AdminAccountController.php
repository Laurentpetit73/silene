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
       
        if($this->getUser() && $this->getUser()->getRoles()[0] == 'ROLE_ADMIN' ){
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/account/login.html.twig');
    }
}
