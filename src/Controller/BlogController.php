<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function show(Article $article, Request $request,ObjectManager $manager)
    {
        $comment = New Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$comment->getId()){
                $comment->setCreatedAT(new \DateTime())
                        ->setArticle($article);

        $manager->persist($comment);
        $manager->flush();
            
        return $this->redirectTORoute('blog_show',['id' => $article->getId()]);
        }}

            


        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
            ]);
    }
}
