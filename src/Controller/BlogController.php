<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $rep)
    {
       /* we can create $rep = $this->getDoctrine()->getRepository(Article::class);
        or just say as parameters with injection of dependence*/

        $articles = $rep->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles
            ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Request $request, ArticleRepository $rep, $id, ObjectManager $em)
    {
        $comment = new Comment();

        $article = $rep->find($id);
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($rep->find($id));

            $em->persist($comment);
            $em->flush();


            return $this->redirectToRoute('show', [
                'id'=> $article->getId(),
            ]);
        }

        return $this->render('blog/show.html.twig', [
            'article'=>$article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/new", name="blog_new")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function addArticle(Article $article = null, Request $request, ObjectManager $em)
    {
        if(!$article) {
            $article = new Article();
        }

       /* we can use the method direct but that will be not clean code because we will duplicate our code..
       $form= $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();
   */
        //  then we use this :
       $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('show', [
                'id'=>$article->getId()
            ]);
        }

        return $this->render('blog/addArticle.html.twig', [
            'formArticle'=>$form->createView(),
            'editmode'=>$article->getId() !== null
        ]);
    }


}
