<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Service\Pagination;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCustomerController extends AbstractController
{
    /**
     * @Route("/admin/customer/{page<\d+>?1}", name="admin_customer")
     */
    public function index($page, Pagination $pagination )
    {
        $pagination->setEntityClass(User::class)
            ->setCurrentPage($page);

        return $this->render('admin/customer/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    /**
     * @Route("/admin/customer/{id}/delete", name="admin_customer_delete")
     */
    public function delete(User $user , EntityManagerInterface $manager )
    {
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success',"L'utilisateur a bien été supprimé");
        return $this->redirectToRoute('admin_customer');
    }
    /**
     * @Route("/admin/customer/{id}/edit", name="admin_customer_edit")
     */
    public function edit(User $user , EntityManagerInterface $manager, Request $request )
    {
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success',"L'utilisateur : ".$user->getEmail()." a bien été modifié");
            return $this->redirectToRoute('admin_customer');
        }
        
        return $this->render('admin/customer/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
}
