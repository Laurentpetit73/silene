<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking/{page<\d+>?1}", name="admin_booking")
     */
    public function index($page, Pagination $pagination )
    {
        $pagination->setEntityClass(Booking::class)
            ->setCurrentPage($page)
            ->setLimit(20);

        return $this->render('admin/booking/index.html.twig', [
            'current_menu' => 'booking',
            'pagination' => $pagination,
        ]);
    }
    /**
     * @Route("/admin/booking/{id}/delete", name="admin_booking_delete")
     */
    public function delete(Booking $booking , EntityManagerInterface $manager )
    {
        $manager->remove($booking);
        $manager->flush();
        $this->addFlash('success',"La reservation a bien été supprimé");
        return $this->redirectToRoute('admin_booking');
    }
}
