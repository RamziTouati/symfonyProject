<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Manager\ContactManager;



class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index( Request $request  ): Response
    {
        // $form = $this->createForm(ContactType::class);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     $contactFormData = $form->getData();

        // //     $message = (new \Swift_Message('You Got Mail!'))
        // //        ->setFrom($contactFormData['from'])
        // //        ->setTo('our.own.real@email.address')
        // //        ->setBody(
        // //            $contactFormData['message'],
        // //            'text/plain'
        // //        )
        // //    ;

        // //    $mailer->send($message);

        //    return $this->redirectToRoute('contact');
        // }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

        /**
     * @Route("/contacts", name="contacts")
     * @param Request $request
     * @param ContactManager $contactManager
     * @return Response
     */
    public function contact(
        Request $request,
        ContactManager $contactManager
    ): Response
    {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $contactManager->sendContact($contact);
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
