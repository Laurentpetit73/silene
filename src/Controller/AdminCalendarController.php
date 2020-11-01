<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Calendar\RenderCalendar;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCalendarController extends AbstractController
{
    /**
     * @Route("/admin/calendar", name="admin_calendar")
     */
    public function index(CalendarRepository $calendar, EntityManagerInterface $manager)
    {
        $booking = New Booking($manager);
        $form = $this->createForm(BookingType::class,$booking);
        $year = '2021';
        $calendaryear = $calendar->findBy(['year' => $year]);
        $cal = new RenderCalendar($year, 3 ,11,$calendaryear);
        //$year = getdate()['year'];

        return $this->render('admin/calendar/calendar.html.twig', [
            'controller_name' => 'Calendar',
            'test' => $cal,
            'year' => $year,
            'form' => $form->createView(),
        ]);
    }
}
