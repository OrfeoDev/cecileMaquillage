<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,EntityManagerInterface $em): Response
    {
        $clients = new Clients();

        $form = $this->createForm(ContactType::class,$clients);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $em->persist($clients);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre demande a bien été envoyé !'
            );
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('contact/index.html.twig', [
            'formView'=>$form->createView()
        ]);
    }
}
