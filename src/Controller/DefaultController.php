<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
