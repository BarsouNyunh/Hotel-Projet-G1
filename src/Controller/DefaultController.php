<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    // ----------------------------- RENDERING DEFAULT-PAGES ----------------------------
    #[Route('/', name: 'show_home', methods: ['GET'])]
    public function showHome(Slider $slider, SliderRepository $sliderRepository): Response
    {
        $sliders = $sliderRepository->findBy(['deletedAt' => null]);

        return $this->render('default/show_home.html.twig', [
            'sliders' => $sliders,
            'slider' => $slider,
        ]);
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
    // ----------------------------------------------------------------------------------

}
