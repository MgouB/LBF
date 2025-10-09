<?php

namespace App\Controller;

use App\Form\DevisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


final class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', []);
    }

    #[Route('/devis', name: 'app_devis', methods: ['GET','POST'])]
    public function devis(Request $request): Response
    {
        $form = $this->createForm(DevisType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {          
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

}
