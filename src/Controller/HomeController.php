<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
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
    public function home(EntityManagerInterface $manager, Request $request, BookingRepository $repo)
    {
        $booking = New Booking($manager);
        $form = $this->createForm(BookingType::class,$booking);

        $test = new BookingService($repo);
        $NotAvailableDay = $test->getNotAvailableDays();


        $form->handleRequest($request);

        if($form->isSubmitted()  &&  $form->isValid()){
            dump($request);
            $manager->persist($booking);
            $manager->flush();

        }

        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
            'form' => $form->createView(),
            'NotAvailableDays' => $NotAvailableDay
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(BookingRepository $repo)
    {
        dump($repo->findAll());
        die();

        return $this->render('home/contact.html.twig', [
            'current_menu' => 'contact',
        ]);
    }

}
