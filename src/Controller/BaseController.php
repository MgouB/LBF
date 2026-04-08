<?php

namespace App\Controller;

use App\Form\DevisType;
use App\Entity\Devis;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DevisRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', []);
    }

    #[Route('/devis', name: 'app_devis', methods: ['GET','POST'])]
    public function devis(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devis = new Devis();

        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {   
            $entityManager->persist($devis);
            $entityManager->flush();    
            
            $this->addFlash('success', 'Votre demande de devis a bien été envoyée !');
            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('base/devis.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/p', name: 'app_propos')]
    public function propos(): Response
    {
        return $this->render('base/propos.html.twig', []);
    }
    
    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        return $this->render('base/services.html.twig', []);
    }

    #[Route('/private-profil', name: 'app_profil')]
    #[IsGranted('ROLE_ADMIN')]
    public function profil(DevisRepository $devisRepository): Response
    {
        return $this->render('base/profil.html.twig', [
            // On récupère tous les devis pour les afficher sur le profil
            'devis' => $devisRepository->findAll(),
        ]);
    }
}

