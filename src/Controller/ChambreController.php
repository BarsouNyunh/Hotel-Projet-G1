<?php

namespace App\Controller;

use DateTime;
use App\Entity\Chambre;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChambreController extends AbstractController
{
    #[Route('/nos-chambres', name: 'show_chambre', methods: ['GET'])]
    public function showChambre(): Response
    {
        return $this->render('chambre/show_chambre.html.twig');
    } // end showChambre()

    #[Route('/admin/ajouter-chambre', name: 'create_chambre', methods: ['GET', 'POST'])]
    public function createChambre(ChambreRepository $repository, Request $request ): Response
    {
        
        $chambre = new Chambre();

        $form = $this->createForm(ChambreFormType::class, $chambre)
        ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $chambre->setCreatedAt(new DateTime());
            $chambre->setUpdatedAt(new DateTime());

            $photo = $form->get('photo')->getData();

            // if($photo) {
                // $this->handleFile($chambre, $photo, $slugger);
            // } 

            $repository->save($chambre, true);

            $this->addFlash('success', "la chambre est été ajouté avec succès !");
            return $this->redirectToRoute('show_home');
        } // end if($form)
        
        
        return $this->render('chambre/show_chambre.html.twig');
    } // end ajouterChambre()
}
