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

        /**
         * $em est une instance de EntityManagerInterface
         * On le reçoit en argument de la méthode index()
         * grâce au mécanisme d'injection de dépendances de Symfony
         */

        // Création de 10 000 articles
        for ($i = 0; $i < 10000; $i++) {
            $article = new Article();
            $article->setTitre('Mon article n° ' . $i);
            $article->setDate(new \DateTime());
            $article->setImg('https://via.placeholder.com/150');
            $article->setContenu('Ceci est le contenu de mon article n° ' . $i . '.');

            // On "persiste" l'article
            // On prépare un INSERT INTO
            $em->persist($article);
        }

        // On exécute les requêtes
        // On "tire la chasse"
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

    #[Route('/articles', name: 'app_article_list')]
    function list(ArticleRepository $ar): Response {

        /**
         * $ar est une instance de ArticleRepository
         * On le reçoit en argument de la méthode list() 
         * grâce au mécanisme d'injection de dépendances de Symfony
         */

        $articles = $ar->findAll(); // On récupère tous les articles en base de données

        // Puis on les passe à la vue pour affichage
        return $this->render('article/list.html.twig', [
            'articles' => $articles
        ]);
    }
}
