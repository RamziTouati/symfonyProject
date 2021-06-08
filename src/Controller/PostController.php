<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{



    /**
     * @Route("/all", name="posts", methods={"GET"})
     */
    public function getMov(PostRepository $postRepository): Response
    {
        $repository= $postRepository->findall();
      
      
        return new JsonResponse($repository);
    }


    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        // aficher la liste des posts
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // pour ajouter un post
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
      

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$imageFile->getExtension();
            $imageFile->move( $this->getParameter('image_posts'), $fileName);
            $post->setImage( $fileName);
            $user = $this->getUser(); // get the current user 
            $post->setUser($user);   // set the current user 

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        // pour recuperer un post
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
                // pour editer un post

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$imageFile->getExtension();
            $imageFile->move( $this->getParameter('image_posts'), $fileName);
            $post->setImage( $fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post): Response
    {
        // pour supprimer un post
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
