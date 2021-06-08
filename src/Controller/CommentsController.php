<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentsController extends AbstractController
{
    
     /**
     * @Route("/comment/add", name="comment_add")
     */
    //ajout d' un commentaire
    public function add(Request $request)
    {
        //recuperer le post par id
        $post_id = $request->request->get('post_id');
        //recuperer l utilisateur connecté
        $user = $this->getUser();
        $post = $this->getDoctrine()
                     ->getRepository(Post::class)
                     ->find($post_id);
        $comment = new Comment();
        $comment->setBody($request->request->get('body'));
        $comment->setUser($user);
        $comment->setPost($post);

        //recuperer le date systeme
        $date = new \DateTime('@'.strtotime('now'));
        //envoyer le date systeme
        $comment->setCreated($date);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        //recuperer le id
        
        $post_id=$post->getId();

        return $this->redirectToRoute('blog_show', [
            'id' => $post_id,
        ]);
    }
}
