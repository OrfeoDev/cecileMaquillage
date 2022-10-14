<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Status;
use App\Entity\Statut;
use App\Repository\ContactRepository;
use App\Repository\StatusRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackofficeController extends AbstractController
{
    #[Route('/admin/backoffice', name: 'app_admin_backoffice', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(ContactRepository $contactRepository, StatutRepository $statutRepository): Response
    {
        //  $contact = $contactRepository->findBy([], ['nom' => 'ASC']);
      //  $contact = $contactRepository->findBy([], ['nom' => 'DESC']);
        //dd($contact);
        $todoStatut = $statutRepository->findOneByValeur("todo");

        $doneStatut = $statutRepository->findOneByValeur("done");

        $demandeTodo = $todoStatut->getContact();
        $demandeDone = $doneStatut->getContact();

        return $this->render('admin/backoffice/index.html.twig', [

            'contact' => $contactRepository->findAll(),
            'demandeTodo' => $demandeTodo,
            'demandeDone' => $demandeDone,

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

    #[Route('admin/backoffice/dashboard/change-status-of-demande/{id}', name: 'app_backoffice_dashboard_change_status_of_demande')]
    #[IsGranted('ROLE_BACKOFFICE')]
    public function changeStatusOfDemande(EntityManagerInterface $manager, StatutRepository $statutRepository, Contact $contact): Response
    {
        /**
         * @var Statut
         */
        $todoStatut = $statutRepository->findOneByValue("todo");
        $todoStatut->removeDemandePro($contact);
        /**
         * @var Statut
         */
        $doneStatut = $statutRepository->findOneByValue("done");
        $doneStatut->addDemandePro($contact);

        $manager->persist($todoStatut);
        $manager->persist($doneStatut);
        $manager->persist($contact);

        $manager->flush();

        $this->addFlash(
            'success',
            'La demande a été traitée avec succès'
        );

        return $this->redirectToRoute('app_backoffice_dashboard');
    }


}
