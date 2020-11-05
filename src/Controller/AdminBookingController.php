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
            ->setTri( ['startDate' => 'DESC'])
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
        $booking->setManager($manager);
        $manager->remove($booking);
        $manager->flush();
        $this->addFlash('success',"La reservation a bien été supprimé");
        return $this->redirectToRoute('admin_booking');
    }
    /**
     * @Route("/admin/booking/{id}/edit", name="admin_booking_edit")
     */
    public function edit(Booking $booking , EntityManagerInterface $manager )
    {
        return $this->render('admin/booking/edit.html.twig', [
            'current_menu' => 'booking',
            'booking' => $booking,
        ]);
    }
    /**
     * @Route("/admin/booking/{id}/confirm", name="admin_booking_confirm")
     */
    public function confirm(Booking $booking , EntityManagerInterface $manager )
    {
        $booking->setIsBooking(true)->setManager($manager)->initialise();
        $manager->persist($booking);
        $manager->flush();
        $this->addFlash('success',"La reservation de <strong>".$booking->getCustomer()->getFullName()."</strong> a bien été accepté");
        return $this->redirectToRoute('admin_booking');
    }
}
