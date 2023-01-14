<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
    #[Route('/auteur_add', name: 'app_auteur_add')]
    public function add(Request $request, AuteurRepository $repo): Response
    {
        $auteur = new Auteur();

        $form = $this->createForm(AuteurType::class , $auteur);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $repo->save($auteur, 1);

            return $this->redirectToRoute('app_auteurs');
        }

        return $this->render('auteur/formulaire.html.twig', [
                'formAuteur' => $form->createView()

        ]);
    }


    #[Route('/auteurs', name: 'app_auteurs')]
    public function showAll(AuteurRepository $repo)
    {
        $auteurs = $repo->findAll();

        return $this->render('auteur/allAuteur.html.twig', [
            'auteurs' => $auteurs 
        ]);
    }

    #[Route('/auteur_{id<\d+>}', name: 'app_auteur')]
    public function show($id, AuteurRepository $repo)
    {
        $auteur = $repo->find($id);

        return $this->render('auteur/oneAuteur.html.twig', [
            'auteur' => $auteur
        ] );
    }



    #[Route('/auteur_update_{id<\d+>}', name: 'app_auteur_update')]
    public function update($id, Request $request, AuteurRepository $repo)
    {
        $auteur = $repo->find($id);

        $form = $this->createForm(AuteurType::class, $auteur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $repo->save($auteur, 1);

            return $this->redirectToRoute('app_auteurs');
        }

        return $this->render('auteur/formulaire.html.twig' , [
            'formAuteur' => $form->createView()
        ]);
    }


    #[Route('/auteur_delete_{id<\d+>}', name: 'app_auteur_delete')]
    public function delete($id, AuteurRepository $repo){

        $auteur = $repo->find($id);

        $repo->remove($auteur, 1);

        return $this->redirectToRoute('app_auteurs');
    }




}
