<?php

namespace App\Controller;

use App\Entity\PriceConfig;
use App\Form\PriceConfigType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPriceController extends AbstractController
{
    /**
     * @Route("/admin/price/{year}", name="admin_price")
     */
    public function index(PriceConfig $priceConfig, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(PriceConfigType::class,$priceConfig);
        $form->handleRequest($request);
        dump($priceConfig);

        if($form->isSubmitted() && $form->isValid() ){
            
            foreach($priceConfig->getSpecialWeeks() as $week){
                
                $week->setPriceConfig($priceConfig);
                $manager->persist($week);
            }
           
            
            $priceConfig->setManager($manager)->update();
            $manager->persist($priceConfig);
            $manager->flush();

        }

        return $this->render('admin/price/index.html.twig', [
            'price' => $priceConfig,
            'current_menu' => 'price',
            'form' => $form->createView(),
        ]);
    }
}
