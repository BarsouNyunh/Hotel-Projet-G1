<?php

namespace App\Controller;

use DateTime;
use App\Entity\Avis;
use App\Entity\Chambre;
use App\Form\AvisFormType;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class AvisController extends AbstractController
{
    // ------------------------------ SHOW-AVIS ------------------------------
    #[Route('/avis', name: 'show_avis', methods: ['GET', 'POST'])]
    public function showAvis(Request $request, AvisRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $avis = new Avis();

        $form = $this->createForm(AvisFormType::class, $avis)
            ->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $avis->setCreatedAt(new DateTime());
            $avis->setUpdatedAt(new DateTime());

            $repository->save($avis, true);

            $this->addFlash('success', "Votre avis a été ajouté avec succès !");

            return $this->redirectToRoute('show_avis');
        }

        $avisTotal = $entityManager->getRepository(Avis::class)->findBy(['deletedAt' => null]);

        return $this->render('avis/show_avis.html.twig', [
            'form' => $form->createView(),
            'avis' => $avis,
            'avisTotal' => $avisTotal,
        ]);
    } // end showAvis()
    // ------------------------------------------------------------------------



    // ------------------------------ DELETE-AVIS -----------------------------
    #[Route('/supprimer-un-avis/{id}', name: 'soft_delete_avis', methods: ['GET'])]
    public function softDeleteAvis(Avis $avis, EntityManagerInterface $entityManager): Response
    {
        $avis->setDeletedAt(new DateTime());

        $entityManager->getRepository(Avis::class)->save($avis, true);

        $this->addFlash('success', "Votre avis a été supprimé.");

        return $this->redirectToRoute('show_avis');
    } // end softDeleteAvis()
    // ------------------------------------------------------------------------




} // end AvisController{}