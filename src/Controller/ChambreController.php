<?php

namespace App\Controller;

use App\Entity\Chambre;
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
    public function createChambre(): Response
    {
        $chambre = new Chambre();
        
        return $this->render('chambre/show_chambre.html.twig');
    } // end ajouterChambre()
}
