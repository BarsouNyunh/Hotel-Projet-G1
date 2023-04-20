<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'nos_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request): Response
    { 
        $form = $this->createForm(ContactFormType::class)
           ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           $this->addFlash('success', "Votre prise de contact a bien été envoyé !");
           return $this->redirectToRoute('nos_contact');
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
