<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Repository\AnnoncesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    public function __construct(AnnoncesRepository $annoncesRepository)
    {
    
        $this->annoncesRepository=$annoncesRepository;
    }

    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        $annonces = $this->annoncesRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'annonces' => $annonces
        ]);
    }
    
    #[Route('admin/edit/{id}', name:'admin_edit', methods: ['GET', 'POST'])]
    public function edit(Annonces $annonce, Request $request, EntityManagerInterface $em): Response
    {
            $form = $this->createForm(AnnoncesType::class,$annonce);
            $form->handleRequest($request);
            //gerer la validité du formulaire
        if ($form->isSubmitted() && $form->isValid()) { 

            $em->flush();
            $this->addFlash('notice', 'insertion réussie');
            return $this->redirectToRoute('admin_index');

           
        }
        return $this->render("admin/edit.html.twig", [
            'form' =>$form->createView(), 'annonce'=>$annonce
            ]);
    }
    #[Route('admin/delete/{id}', name:'admin_delete')]
    public function delete(Annonces $annonce,EntityManagerInterface $em)
    {
        $em->remove($annonce);
        $em->flush();
        $this->addFlash('notice', 'suppression réussie');
        return $this->redirectToRoute('admin_index');
    }
}
