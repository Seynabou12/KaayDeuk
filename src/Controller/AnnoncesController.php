<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Annonces;
use App\Form\CommentType;
use App\Form\AnnoncesType;
use Cocur\Slugify\Slugify;
use App\Repository\AnnoncesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AnnoncesController extends AbstractController
{

    public function __construct(AnnoncesRepository $annoncesRepository)
    {

        $this->annoncesRepository = $annoncesRepository;
    }
    #[Route('/annonces', name: 'annonces_index', methods: ['GET'])]
    public function index(): Response
    {

        $annonces = $this->annoncesRepository->findAll();

        return $this->render('annonces/index.html.twig', [
            'annonces' => $annonces
        ]);
    }

    #[Route('annonces/edit/{id}', name: 'annonces_edit', methods: ['GET', 'POST'])]
    public function edit(Annonces $annonce, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);
        //gerer la validité du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $this->addFlash('notice', 'insertion réussie');
            return $this->redirectToRoute('annonces_index');
        }
        return $this->render("annonces/edit.html.twig", [
            'form' => $form->createView(), 'annonce' => $annonce
        ]);
    }
    #[Route("/annonces/create", name: ("annonces_create"))]
    public function form(Request $request, EntityManagerInterface $em)
    {
        $annonce = new Annonces();
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);
        //tester si le formulaire est envoyer et valider
        if ($form->isSubmitted() && $form->isValid()) {
            //recuperation de l'image depuis le formulaire
            $coverImageFile = $form->get('coverImage')->getData();
            //creation d'un nom pour l'image avec l'extensionrecuopérée
            if ($coverImageFile) {
                $slugger = new Slugify();
                $originalFilename = pathinfo($coverImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slugify($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $coverImageFile->guessExtension();

                //on deplace l'image dans le répertoire coverImage_directory avec le nom créé
                try {
                    $coverImageFile->move(
                        $this->getParameter('coverImage_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                //on enregistre le nom de l'iùage dans la base de donnée
                $annonce->setCoverImage($newFilename);
            }
            //corrélation entre les objets
            //on persist et on enregistre l'annonce
            $em->persist($annonce);
            $em->flush();

            $this->addFlash('notice', 'insertion réussie');

            return $this->redirectToRoute('annonces_index');
        }
        return $this->render("annonces/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }
    #[Route('annonces/show/{id}', name: 'annonces_show', methods: ['GET', 'POST'])]
    public function show(Annonces $annonce, Request $request, EntityManagerInterface $em): Response
    {
        //Partie Commentaire
        //on cré le commentaire vierge
        $comment = new Comment;

        //On génére le formulaire

        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        //traitement du formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment->setCreatedAt(new DateTime());
            $comment->setAnnonce($annonce);
           
           //$annonce->addComment($comment);
            $em->persist($comment);
            $em->flush();

            
            
            return $this->redirectToRoute('annonces_show', ['id' => $annonce->getId()]);
        }
        return $this->render('annonces/show.html.twig', [
            'annonce' => $annonce,
            'commentForm' => $commentForm->createView()
        ]);
    }
    #[Route('annonces/delete/{id}', name: 'annonces_delete')]
    public function delete(Annonces $annonce, EntityManagerInterface $em)
    {
        $em->remove($annonce);
        $em->flush();
        $this->addFlash('notice', 'suppression réussie');
        return $this->redirectToRoute('annonces_index');
    }
}
