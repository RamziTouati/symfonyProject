<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
        
    {
        //permet de trouver les posts dans la base et les afficher par ordre decroissant avec la contrainte temps
        $posts =$this->getDoctrine()->getRepository(Post::class)
                        ->findBy([],['time'=>'DESC']);

        //les 5 dernier posts
        $latests = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findBy([],['time'=>'DESC'],5);

        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
            'latests' => $latests
        ]);
    }
    /**
     * @Route("/blog/{id}", name="blog_show",requirements={"id"=".+"})
     */
    public function show($id)
        // recuperer un post par le id (lire la suite)
    {
        $rst=[]  ;
        $post = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findOneBy(['id' => $id]);
        $latests = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findBy([],['time'=>'DESC'],5);

        $comments = $this->getDoctrine()
                        ->getRepository(Comment::class)
                        ->findBy(['post'=>$post]);

        return $this->render('blog/show.html.twig', [
            'post' => $post,
            'latests' => $latests,
            'comments' => $comments,
        ]);
    }
     /**
     * @Route("/posts/{username}", name="user_posts")
     */
    public function renderUserPosts(User $user)
        // recuperer touts les posts d'un utilisateur par son nom
    {
        $posts = $this->getDoctrine()
                        ->getRepository(Post::class)
                        ->findBy(['user' => $user],['time'=>'DESC']);
        

        return $this->render('blog/user_posts.html.twig', [
            'posts' => $posts,
            'user' => $user
        ]);
    }
    
}
