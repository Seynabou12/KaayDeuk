<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Annonces;
use App\Entity\Comment;
use App\Entity\Image;
use DateTime;
use Faker\Factory;
use Cocur\Slugify\Slugify;
use PhpParser\Node\Expr\AssignOp\Div;

class AnnonceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $slugger = new Slugify();
        for ($i=1; $i<22; $i++)
        {
            $annonce = new Annonces();
           // $title = $faker->sentence(3);
            $annonce->setTitle($faker->sentence(4, false))
                    ->setIntroduction($faker->text(200))
                    ->setCoverImage("location_image.jpg")
                    ->setSlug($slugger->slugify($annonce->getTitle()))
                    ->setAdresse($faker->address())
                    ->setPrice(mt_rand(30000, 60000))
                    ->setDescription($faker->text(300))
                    ->setRoom(mt_rand(1, 5))
                    ->setIsAvailable(mt_rand(0, 1))
                    ->setCreatedAt($faker->dateTimeBetween('-3 month', 'now'));

                    //on donne des commentaires à annonce

                    for ($j=0; $j<mt_rand(0, 10); $j++)
                    {
                        $comment = new Comment();
                        $comment->setAuthor($faker->name())
                                ->setEmail($faker->email())
                                ->setContent($faker->text(300))
                                ->setCreatedAt($faker->dateTimeBetween('-3 month', 'now'))
                                ->setAnnonce($annonce);

                                //65-$manager->persist($comment); //permet à doctrine d'enregistrer le commentaire dans le blog
                                $annonce->addComment($comment);
                    }
                    //on met des images dans l'annonce
                    for ($k=0; $k<mt_rand(0, 6); $k++)
                    {
                        $image = new Image();
                        $image->setImageUrl("https://picsum.photos/768/500?random=" . mt_rand(1,50000))
                                ->setDescription($faker->text())
                                ->setAnnonce($annonce);

                                //$manager->persist($image); //permet à doctrine d'enregistrer l'images dans le blog
                                $annonce->addImage($image);
                    }
                $manager->persist($annonce); //permet a doctrine d'enregistrer l'annonce dans la blog
        }
                $manager->flush(); // Execute  l'enregistrement des données persistées 
    }
}
