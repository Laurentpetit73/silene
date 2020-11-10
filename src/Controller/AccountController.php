<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Message;
use App\Form\ProfilType;
use App\Form\MessageType;
use App\Entity\PasswordUpdate;
use App\Service\MessageService;
use App\Form\PasswordUpdateType;
use App\Repository\BookingRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Sample\CaptureIntentExamples\CreateOrder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account_user")
     */
    public function myAccount()
    {
        $user = $this->getUser();
        
        return $this->render('user/index.html.twig', [
            'user' => $user ,
            'current_menu' => '', 
        ]);
    }

    /**
     * @Route("/account/profil", name="account_profil")
     * @IsGranted("ROLE_USER")
     */
    public function profil( Request $request, EntityManagerInterface $manager)
    {
        
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success',"Votre Compte <strong>".$user->getEmail()."</strong> a bien été modifié");
            return $this->redirectToRoute('account_user');
        }
       
        
        return $this->render('account/profil.html.twig', [
            'form' => $form->createView(),
            'current_menu' => '', 
             
        ]);
    }
    /**
     * @Route("/account/update-pass", name="account_pass")
     * @IsGranted("ROLE_USER")
     */
    public function updatePass( Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $pass = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class, $pass);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(password_verify($pass->getOldPass(),$user->getPassword())){
                $hash = $encoder->encodePassword($user,$pass->getNewPass());
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success',"Le mot de passe de  <strong>".$user->getEmail()."</strong> a bien été modifié");
                return $this->redirectToRoute('account_user');
            }else{
                $form->get('oldPass')->addError(new FormError('Votre ancien mot de pass ne correspond pas'));
                
            }
        }
        return $this->render('account/pass.html.twig', [
            'form' => $form->createView(),
            'current_menu' => '', 
             
        ]);
    }
    /**
     * @Route("/account/bookings/{id}", name="account_bookings",defaults={"id": ""})
     * @IsGranted("ROLE_USER")
     */
    public function booking(Booking $booking=null, Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        if($booking == null){
        
        $booking = $user->getbookings()[$user->getbookings()->count() -1];
        }

        $allbooking=[];
        for($i=$user->getbookings()->count()-1;$i>=0 ;$i--){
        $allbooking[] = $user->getbookings()[$i];
        }

        $message = new Message();
        $form = $this->createForm(MessageType::class,$message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $messageService = new MessageService($manager,$booking);
            $messageService->sendCustomerMessage($message);

        }
        

        return $this->render('account/booking.html.twig',[
            'current_menu' => '', 
            'booking' => $booking,
            'allbooking' => $allbooking,
            'form'=>$form->createView()
        ]);
    }
}
