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
    public function showHome(SliderRepository $sliderRepository): Response
    {
        $slider1 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => '1'
        ]);
        $slider2 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => '2'
        ]);
        $slider3 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => '3'
        ]);

        return $this->render('default/show_home.html.twig', [
            'slider1' => $slider1,
            'slider2' => $slider2,
            'slider3' => $slider3
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

    #[Route('/acces', name: 'show_map', methods: ['GET'])]
    public function showMap(): Response
    {
        return $this->render('contact/map.html.twig');
    } // end showMap()

    #[Route('/nous', name: 'show_nous', methods: ['GET'])]
    public function showNous(): Response
    {
        return $this->render('contact/nous.html.twig');
    } // end showMap()


}
