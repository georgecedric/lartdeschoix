<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ArticleType;
class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles =$repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null,Request $request,ObjectManager $manager)
    {
        if(!$article){
            $article = new article();
        }
        

        $formArticle = $this->createForm(ArticleType::class, $article);

        $formArticle ->handleRequest($request);
        if($formArticle->isSubmitted() && $formArticle->isValid()){
            if(!$article->getId()){
                $article->setCreatedAT(new \DateTime());
            }

            
            $manager->persist($article);
            $manager->flush();

            return $this->redirectTORoute('blog_show',['id' => $article->getId()]);
        }

        dump ($article);
                    
        return $this->render('blog/create.html.twig', [
            'formArticle' => $formArticle->createView(),
            'editMode' => $article->getId() !== null
            ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article)
    {
        
        return $this->render('blog/show.html.twig', [
            'article' => $article
            ]);
    }
}
