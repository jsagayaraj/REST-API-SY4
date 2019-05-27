<?php

namespace App\Controller;

use App\Entity\Article;
use FOS\RestBundle\View\View;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */

class ArticleController extends AbstractController
{
    
    /**
     * @Rest\Post("/article")
     */
    public function postArticle(Request $request)
    {
        $article = new Article();
        $article->setName($request->get('name'));
        $article->setDescription($request->get('description'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($article, Response::HTTP_CREATED , []);
        
    }


    /**
     * Lists all Articles.
     * @Rest\Get("/articles")
     *
     * @return array
     */
    public function getArticles()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        
        // query for a single Product by its primary key (usually "id")
        $article = $repository->findall();
        
         // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($article, Response::HTTP_OK , []);
    }


    /**
     * 
     * @Rest\Get("/article/{id}")
     */
    public function getArticle($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->findById($id);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($article, Response::HTTP_OK);
    }
}
