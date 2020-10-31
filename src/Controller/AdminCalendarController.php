<?php

namespace App\Controller;

use App\Calendar\RenderCalendar;
use App\Repository\CalendarRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCalendarController extends AbstractController
{
    /**
     * @Route("/admin/calendar", name="admin_calendar")
     */
    public function index(CalendarRepository $calendar)
    {
        $year = '2020';
        $calendaryear = $calendar->findBy(['year' => $year]);
        $cal = new RenderCalendar($year, 3 ,11,$calendaryear);
        //$year = getdate()['year'];

        return $this->render('admin/calendar/calendar.html.twig', [
            'controller_name' => 'Calendar',
            'test' => $cal,
            'year' => $year
        ]);
    }
}
