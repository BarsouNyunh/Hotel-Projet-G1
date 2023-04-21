<?php

namespace App\Controller;

use App\Entity\Chambre;
use App\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'show_home', methods: ['GET'])]
    public function showHome(): Response
    {
        return $this->render('default/show_home.html.twig');
    }

    #[Route('/spa', name: 'show_spa', methods: ['GET'])]
    public function showSpa(): Response
    {
        return $this->render('default/show_spa.html.twig');
    }
    
    #[Route('/notre-resto', name: 'show_resto', methods: ['GET'])]
    public function showResto(): Response
    {
        return $this->render('default/show_resto.html.twig');
    }

    #[Route('/nos-chambres', name: 'show_chambre', methods: ['GET'])]
    public function showChambre(): Response
    {
        return $this->render('chambre/show_chambre.html.twig');
    } // end showChambre()

    // #[Route('/{cat_alias}/{art_alias}_{id}.html', name: 'show_one_chambre', methods: ['GET'])]
    // public function showOneChambre(Chambre $chambre, AvisRepository $avisRepository): Response
    // {
    //     $items = $avisRepository->findBy(['deletedAt' => null, 'chambre' => $chambre->getId()]);

    //     return $this->render('default/show_chambre.html.twig', [
    //         'chambre' => $chambre,
    //         'items' => $items
    //     ]);
    // }

}
