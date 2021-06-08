<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    /**
     * @Route("/register", name="register_user")
     */
    public function register(Request $request,UserPasswordEncoderInterface $PasswordEncoder,EntityManagerInterface $entityManager ): Response
    {   
        //nouvelle instance
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){
            $password = $PasswordEncoder->encodePassword(
                $user,$user->getConfirmPassword()
            );
                $user->setPassword($password);
                $user->setRoles(['ROLE_USER']);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                //afficher un message 
                
                $this->addFlash(
                    'notice',
                    'Compte crée avec succés!'
                );  
            return $this->redirectToRoute('security_login');
        }

        
        return $this->render('users/register.html.twig', [
           'form' => $form->createView()
        ]);
    }
}
