<?php

namespace App\Controller;

use DateTime;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function showAll(ArticleRepository $repo): Response
    {
        // on récupere les articles en passant par un objet de l'ArticleRepository et en utilisant la methode findAll()
        $articles = $repo->findAll();
        
        // dd() est une fonction de debogage (équivalent d'un var_dump() et die() en même temps)
        //dd($articles);
        
        return $this->render('article/allArticles.html.twig', [
                'articles' => $articles 
        ]);
    }


    // <\d+> est une regex qui permet de dire que l'information qu'on met dans l'id doit être un entier de 1 à l'infini. sans quoi cette route pourrait être confondu avec d'autres. ex: la route suivante /article_add, le add aurait été pris pour un id et donc intercepté avant d'y arrivé 
    #[Route('/article_{id<\d+>}', name: 'app_article')]
    public function show($id, ArticleRepository $repo){

        $article = $repo->find($id);

        //dd($article);

        return $this->render('article/oneArticle.html.twig' , [
            'article' => $article
        ]);

    }


    #[Route('/article_add', name: 'app_article_add')]
    public function add(Request $request, ArticleRepository $repo)
    {
        //on crée un objet de la class Article
        $article = new Article();

        //on crée le formulaire en liant le ArticleType à l'objet $article
        $form = $this->createForm(ArticleType::class, $article);

        // on donne accés aux donnée post du formulaire
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $article->setDateDeCreation(new DateTime("now"));

            // la methode save() me permet de faire un persist puis un flush en ajoutant le 2éme paramétre 1 ou true. elle se trouve dans le repository ArticleRepository
            $repo->save($article, 1);

            // aprés avoir ajouté l'article en bdd, on redirige vers la page de tous les articles
            return $this->redirectToRoute("app_articles");

        }

        return $this->render('article/formArticle.html.twig', [
            //on crée la vue du formulaire pour l'afficher dans le template
            'formArticle' => $form->createView()
        ]);
    }



    #[Route('/article_update_{id<\d+>}', name: 'app_article_update')]
    public function update($id, Request $request, ArticleRepository $repo)
    {
         //on recupére l'article dont l'id est celui passé en paramétre de la route, qui est automatiquement recupéré dans le $id de la fonction, pour pouvoir le modifier 
         $article = $repo->find($id);

         //on crée le formulaire en liant le ArticleType à l'objet $article
         $form = $this->createForm(ArticleType::class, $article);
 
         // on donne accés aux donnée post du formulaire
         $form->handleRequest($request);
 
         if( $form->isSubmitted() && $form->isValid())
         {
             $article->setDateDeModification(new DateTime("now"));
 
             // la methode save() me permet de faire un persist puis un flush en ajoutant le 2éme paramétre 1 ou true. elle se trouve dans le repository ArticleRepository
             $repo->save($article, 1);
 
             // aprés avoir ajouté l'article en bdd, on redirige vers la page de tous les articles
             return $this->redirectToRoute("app_articles");
 
         }
 
         return $this->render('article/formArticle.html.twig', [
             //on crée la vue du formulaire pour l'afficher dans le template
             'formArticle' => $form->createView()
         ]);
    }

    #[Route('/article_delete_{id<\d+>}', name: 'app_article_delete')]
    public function delete($id, ArticleRepository $repo)
    {
            $article = $repo->find($id);
    // la methode rmeove() me permet de faire un remove puis un flush en ajoutant le 2éme paramétre 1 ou true. elle se trouve dans le repository ArticleRepository
            $repo->remove($article,1);

            return $this->redirectToRoute("app_articles");
    }


}
