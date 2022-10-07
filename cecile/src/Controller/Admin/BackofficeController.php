<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackofficeController extends AbstractController
{
    #[Route('/admin/backoffice', name: 'app_admin_backoffice',methods:['GET'])]
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

   // #[Route('/admin/backoffice/{id} ', name: 'admin_modifer')]
   //{
      // $contact = $em->getRepository(Contact::class)->find($id);

      //  if (!$contact) {

       //     throw $this->createNotFoundException('pas de nom' . $id);
     //   }

     //  $em->flush();

       //return $this->redirectToRoute('app_admin_backoffice', ['id' => $contact->getId()]);
  //  }

    #[Route('/admin/backoffice/{id}/suppression', name: 'admin_suppression')]
    public function supprimer(EntityManagerInterface $em, ContactRepository $contactRepository, Contact $contact): Response
    {
        $em->remove($contact);
        $em->flush();

        return $this->redirectToRoute('app_admin_backoffice');
    }


}
