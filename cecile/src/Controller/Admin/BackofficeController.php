<?php

namespace App\Controller\Admin;

use App\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackofficeController extends AbstractController
{
    #[Route('/admin/backoffice', name: 'app_admin_backoffice')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(ContactRepository $contactRepository): Response
    {
      //  $contact = $contactRepository->findBy([], ['nom' => 'ASC']);
        $contact = $contactRepository->findBy([], ['nom' => 'ASC']);
        //dd($contact);
        return $this->render('admin/backoffice/index.html.twig', [
            'contact' => $contact,
        ]);
    }
}
