<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ArticleController extends AbstractController {
    #[Route('/articles/create', name: 'app_article')]
    public function index(EntityManagerInterface $em): Response {

        for ($i = 0; $i < 10000; $i++) {
            $article = new Article();
            $article->setTitre('Mon article n° ' . $i);
            $article->setDate(new \DateTime());
            $article->setImg('https://via.placeholder.com/150');
            $article->setContenu('Ceci est le contenu de mon article n° ' . $i . '.');

            $em->persist($article);
        }

        $em->flush();

        return new Response('Article créé');
    }

    #[Route('/articles/remove', name: 'app_article_remove')]
    function remove(ArticleRepository $ar, EntityManagerInterface $em) {
        $articles = $ar->findAll();

        foreach ($articles as $article) {
            $em->remove($article);
        }

        $em->flush();

        return new Response('Articles supprimés');
    }
}
