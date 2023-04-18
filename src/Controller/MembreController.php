<?php

namespace App\Controller;

use DateTime;
use App\Entity\Membre;
use App\Form\MembreFormType;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
class MembreController extends AbstractController
{
    // --------------------------------------- REGISTER ---------------------------------------
    #[Route('/dash-admin', name: 'create_membre', methods: ['GET', 'POST'])]
    public function register(Request $request, MembreRepository $membreRepository, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        $membre = new Membre();

        $form_membre = $this->createForm(MembreFormType::class, $membre)
            ->handleRequest($request);

        if($form_membre->isSubmitted() && $form_membre->isValid()) {

            $membre->setCreatedAt(new DateTime());
            $membre->setUpdatedAt(new DateTime());
            $membre->setRoles(['ROLE_ADMIN']);
            
            $membre->setPassword(
                $hasher->hashPassword($membre, $membre->getPassword())
            );

            $membreRepository->save($membre, true);

            $this->addFlash('success', "L'ajout d'un nouveau administrateur, DONE !");

            return $this->redirectToRoute('create_membre');
        } // end if($form_membre)

        $membres = $entityManager->getRepository(Membre::class)->findBy(['deletedAt' => null]);

        return $this->render('admin/register.html.twig', [
            'form_membre' => $form_membre->createView(),
            'membre' => $membre,
            'membres' => $membres,
        ]);
    } // end register()
    // ----------------------------------------------------------------------------------------



    // ------------------------------------ UPDATE-MEMBRE -------------------------------------
    #[Route('/modifier-membre/{id}', name: 'update_membre', methods: ['GET', 'POST'])]
    public function updateMembre(Membre $membre, Request $request, MembreRepository $repository, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        $form_membre = $this->createForm(MembreFormType::class, $membre)
            ->handleRequest($request);

        if($form_membre->isSubmitted() && $form_membre->isValid()) {

            $membre->setUpdatedAt(new DateTime());

            $membre->setPassword(
                $hasher->hashPassword($membre, $membre->getPassword())
            );

            $repository->save($membre, true);

            $this->addFlash('success',"La modification a bien été enregistrée.");
            return $this->redirectToRoute('create_membre');

        } // end if($form_membre)

        $membres = $entityManager->getRepository(Membre::class)->findBy(['deletedAt' => null]);

        return $this->render('admin/register.html.twig', [
            'form_membre' => $form_membre->createView(),
            'membre' => $membre,
            'membres' => $membres,

        ]);
    } // end updateMembre()
    // ----------------------------------------------------------------------------------------



    // --------------------------------- SOFT-DELETE-MEMBRE ----------------------------------
    #[Route('/archiver-un-membre/{id}', name: 'soft_delete_membre', methods: ['GET'])]
    public function softDeleteMembre(Membre $membre, MembreRepository $repository): Response
    {
        $membre->setDeletedAt(new DateTime());

        $repository->save($membre, true);

        $this->addFlash('success', "Le membre admin a bien été archivé !");
        return $this->redirectToRoute('create_membre');
    } // end softDeleteMembre()
    // ----------------------------------------------------------------------------------------



    // ------------------------------------ RESTORE-MEMBRE ------------------------------------
    #[Route('/restaurer-membre/{id}', name: 'restore_membre', methods: ['GET'])]
    public function restoreMembre(Membre $membre, MembreRepository $repository): Response
    {
        $membre->setDeletedAt(null);

        $repository->save($membre, true);

        $this->addFlash('success', "Le membre a bien été restauré !");
        return $this->redirectToRoute('create_membre');
    } // end restoreMembre()
    // ----------------------------------------------------------------------------------------



    // ---------------------------------- HARD-DELETE-MEMBRE ----------------------------------
    #[Route('/supprimer-membre/{id}', name: 'hard_delete_membre', methods: ['GET'])]
    public function hardDeleteMembre(Membre $membre, MembreRepository $repository): Response
    {
        $repository->remove($membre, true);

        $this->addFlash('success', "Le membre a bien été supprimé définitivement !");
        return $this->redirectToRoute('create_membre');
    } // end hardDeleteMembre()
    // ----------------------------------------------------------------------------------------
}
