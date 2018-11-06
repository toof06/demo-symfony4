<?php

namespace App\DataFixtures;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;




class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('de_DE');

        for ($i=1; $i<=5; $i++) {
            $category= new Category();
            $category->setTitle($faker->sentence(4))
                     ->setDescription($faker->paragraph());

            $manager->persist($category);


            // we want to create between 4 and 6 articles
            for ($j=1; $j<=mt_rand(4,6); $j++) {
                $article = new Article();

                $content = "<p> " . join($faker->paragraphs(5), '<p/><p>') . "</p>";

                $article->setTitle($faker->sentence(6))
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween("- 6 months"))
                    ->setCategory($category);
                $manager->persist($article);

                // we give a comment
                for ($k = 1; $k <= mt_rand(4, 6); $k++) {
                    $comment = new Comment();

                    $content = "<p> " . implode($faker->paragraphs(2), '<p/><p>') . "</p>";

                    $now = new \DateTime();
                    $interval = $now->diff($article->getCreatedAt());
                    $days = $interval->days;
                    $minimum = "-" . $days . "days.";

                    $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                        ->setArticle($article);

                    $manager->persist($comment);

                }
            }
        }

        $manager->flush();
    }
}
