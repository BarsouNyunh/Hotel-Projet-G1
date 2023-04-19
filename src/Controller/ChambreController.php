<?php

namespace App\Controller;

use DateTime;
use App\Entity\Chambre;
use App\Form\ChambreFormType;
use App\Repository\ChambreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin')]
class ChambreController extends AbstractController
{
    #[Route('/ajouter-chambre', name: 'create_chambre', methods: ['GET', 'POST'])]
    public function createChambre(ChambreRepository $repository, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $chambre = new Chambre();

        $form_chambre = $this->createForm(ChambreFormType::class, $chambre)
        ->handleRequest($request);

        if($form_chambre->isSubmitted() && $form_chambre->isValid()) {

            $chambre->setCreatedAt(new DateTime());
            $chambre->setUpdatedAt(new DateTime());

            $photo = $form_chambre->get('photo')->getData();

            if($photo) {
                $this->handleFile($photo, $chambre, $slugger);
            } 

            $repository->save($chambre, true);

            $this->addFlash('success', "la chambre est été ajouté avec succès !");
            return $this->redirectToRoute('create_chambre');
        } // end if($form_chambre)

        $chambres = $entityManager->getRepository(chambre::class)->findBy(['deletedAt' => null]);
        
        
        return $this->render('admin/chambre.html.twig', [
            'form_chambre' => $form_chambre->createView(),
            'chambre' => $chambre,
            'chambres' => $chambres
        ]);
    } // end ajouterChambre()

    //-----------------------------------MODIFIER CHAMBRE-------------------------------------------

    #[Route('/modifier-un-chambre/{id}', name: 'update_chambre', methods: ['GET', 'POST'])]
    public function updateChambre( Chambre $chambre, Request $request, ChambreRepository $repository, SluggerInterface $slugger): Response 
    {
     # Récupération de la photo actuelle
     $currentPhoto = $chambre->getPhoto();

     $form = $this->createForm(ChambreFormType::class, $chambre, [
         'photo' => $currentPhoto
     ])
         ->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
 
             $chambre->setUpdatedAt(new DateTime());
                    

             $photo = $form->get('photo')->getData();
 
             if($photo) {
                 $this->handleFile($photo, $chambre, $slugger);
 
             }else{
               
                 $chambre->setPhoto($currentPhoto);
             // end if($newPhoto)
             }
             $repository->save($chambre, true);

             $this->addFlash('success', "La chambre a bien été modifier  avec succès !");
             return $this->redirectToRoute('create_chambre');
         } //end if($form)
 
         return $this->render('admin/chambre.html.twig', [
             'form' => $form->createView(),
             'chambre' => $chambre
         ]);
    } // end updateChambre()

    // ------------------------------ SOFT-DELETE-CHAMBRE -------------------------------
    #[Route('/archiver-un-chambre/{id}', name: 'soft_delete_chambre', methods: ['GET'])]
    public function softDeleteChambre(Chambre $chambre, ChambreRepository $repository): Response
    {
        $chambre->setDeletedAt(new DateTime());

        $repository->save($chambre, true);

        $this->addFlash('success', "La chambre a bien été archivé !");
        return $this->redirectToRoute('create_chambre');
    } // end softDeletechambre()
    // ----------------------------------------------------------------------------------

    // -------------------------------- RESTORE-CHAMBRE ---------------------------------
    #[Route('/restaurer-chambre/{id}', name: 'restore_chambre', methods: ['GET'])]
    public function restoreChambre(Chambre $chambre, ChambreRepository $repository): Response
    {
        $chambre->setDeletedAt(null);

        $repository->save($chambre, true);

        $this->addFlash('success', "La chambre a bien été restauré !");
        return $this->redirectToRoute('create_chambre');
    } // end restorechambre()
    // ----------------------------------------------------------------------------------

    // ------------------------------ HARD-DELETE-CHAMBRE -------------------------------
    #[Route('/supprimer-chambre/{id}', name: 'hard_delete_chambre', methods: ['GET'])]
    public function hardDeleteChambre(Chambre $chambre, ChambreRepository $repository): Response
    {
        $repository->remove($chambre, true);

        $this->addFlash('success', "La chambre a bien été supprimé définitivement !");
        return $this->redirectToRoute('create_chambre');
    } // end hardDeleteChambre()
    // ----------------------------------------------------------------------------------

    // ----------------------------------- HANDLEFILE -----------------------------------
    private function handleFile(UploadedFile $photo, Chambre $chambre, SluggerInterface $slugger)
    {
        $extension = '.' . $photo->guessExtension();
        $safeFilename = $slugger->slug(pathinfo($photo->getClientOriginalExtension(), PATHINFO_FILENAME));

        $newFilename = $safeFilename . '-' . uniqid() . $extension;

        try{
            $photo->move($this->getParameter('uploads_dir'), $newFilename);
            $chambre->setPhoto($newFilename);
        } catch (FileException $exception) {
            // code à exécuter en cas d'erreur
        }
    } // end handleFile()
    // ----------------------------------------------------------------------------------
} // end classController()
