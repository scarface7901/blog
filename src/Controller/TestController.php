<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        $prenom = "Hocine";
        $nom = "Boussaid";

        $tab = [ 
                    'personne1' => [ 
                                    'nom' => 'Boussaid', 
                                    'prenom' => 'Hocine'
                                    ]
                                    ,
                    'personne2' => [
                                    'nom' => 'Toto',
                                    'prenom' => "Tata"
                                    ] 
                ];

        return $this->render("test.html.twig", [ 
            'prenom' => $prenom,
            'nom' => $nom,
            'personnes' => $tab
        ]);

    }



    
    #[Route('/test-home', name: 'app_test-home')]
    public function testHome(){

        $article = [
                        'titre' => 'décideurs de l\'avenir de Noël Le Graët, qui sont les membres du comité exécutif de la FFF ?',
                        'dateDeCreation' => '11/01/2023',
                        'auteur' => 'le journaliste',
                        'contenu' => "Depuis quelques jours, l'attention médiatique s'est portée subitement sur eux. Ils sont quatorze membres dont trois femmes à siéger au sein du comité exécutif (Comex) de la Fédération française de football, qui se réunit en urgence, mercredi 11 janvier, à 11 heures, pour décider de l'avenir de son président Noël Le Graët."
        ];

        return $this->render('home/index.html.twig', [
            'article' => $article
        ]);
    }



}
