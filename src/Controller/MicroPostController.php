<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }
    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }
    #[Route('/micro-post/create', name: 'app_micro_post_create', priority: 2)]
    public function add(Request $request, MicroPostRepository $posts): Response
    {
        $microPost = new MicroPost();
        $formBuilder = $this->createFormBuilder($microPost);
        $form = $formBuilder
            ->add('title', TextType::class)
            ->add('text', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreated(new \DateTime());
            $posts->add($post, true);

            $this->addFlash('success', 'Post created!');

            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render('micro_post/create.html.twig', [
                'form' => $form,
            ]);
    }

    #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response
    {
        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('text', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $posts->add($post, true);

            $this->addFlash('success', 'Post updated!');

            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render('micro_post/create.html.twig', [
            'form' => $form,
        ]);
    }
}
