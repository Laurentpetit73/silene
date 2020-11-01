<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Calendar\RenderCalendar;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCalendarController extends AbstractController
{
    /**
     * @Route("/admin/calendar/{year}", name="admin_calendar")
     */
    public function index(CalendarRepository $calendar, EntityManagerInterface $manager, Request $request, $year = '2024')
    {
        $booking = New Booking($manager);
        $form = $this->createForm(BookingType::class,$booking);
        $calendaryear = $calendar->findBy(['year' => $year]);
        $cal = new RenderCalendar($year, 3 ,11,$calendaryear);
        //$year = getdate()['year'];
        $form->handleRequest($request);

        if($form->isSubmitted()  &&  $form->isValid()){
            $booking->setIsBooking(true);
            $manager->persist($booking);
            $manager->flush();

            $this->redirectToRoute('admin_calendar');

        }

        return $this->render('admin/calendar/calendar.html.twig', [
            'controller_name' => 'Calendar',
            'test' => $cal,
            'year' => $year,
            'form' => $form->createView(),
        ]);
    }
}
