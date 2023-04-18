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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
class MembreController extends AbstractController
{
    // --------------------------------------- REGISTER ---------------------------------------
    #[Route('/dash-admin', name: 'create_membre', methods: ['GET', 'POST'])]
    public function register(Request $request, MembreRepository $membreRepository, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        $membre = new Membre();

        $form_membre= $this->createForm(MembreFormType::class, $membre)
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
}
