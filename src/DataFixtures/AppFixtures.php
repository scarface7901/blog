<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i=1; $i <= 10; $i++) { 
            
            $article = new Article();
    
            $article->setTitre("le titre de l'article $i")
                    ->setContenu("$i Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro, cumque aperiam! Veniam exercitationem eveniet sapiente reiciendis suscipit at aut sint, illo tempore recusandae possimus voluptates, eius libero soluta iusto. Non.")
                    ->setDateDeCreation(new DateTime("now"));

            $manager->persist($article);   
            
        }

        $manager->flush();
    }
}
