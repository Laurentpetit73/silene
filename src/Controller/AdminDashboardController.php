<?php

namespace App\Controller;

use App\Service\BookingService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(BookingService $bookingservice)
    {
        $notconfirm = $bookingservice->getNotConfirmBooking();
        return $this->render('admin/dashboard/index.html.twig', [
            'current_menu' => 'dashboard',
            'notconfirm' => $notconfirm,
        ]);
    }
}
