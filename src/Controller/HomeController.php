<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\CalendarRepository;
use App\Service\BookingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $manager, Request $request, BookingService $bookingservice)
    {
        $booking = New Booking($manager);
        $form = $this->createForm(BookingType::class,$booking);

        $NotAvailableDay = $bookingservice->getNotAvailableDays();
        $NotAvailableDayEnd = $bookingservice->getNotAvailableDaysEnd();

        $form->handleRequest($request);

        if($form->isSubmitted()  &&  $form->isValid()){
            dump($request);
            $manager->persist($booking);
            $manager->flush();

        }

        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
            'form' => $form->createView(),
            'NotAvailableDays' => $NotAvailableDay,
            'NotAvailableDaysEnd' => $NotAvailableDayEnd
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(BookingRepository $repo)
    {

        return $this->render('home/contact.html.twig', [
            'current_menu' => 'contact',
        ]);
    }

}
