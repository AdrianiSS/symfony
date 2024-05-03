<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    private array $messages = [
        "Hello", "Hi", "Bye"
    ];

    #[Route('/{limit?3}', name: 'app_index')]
    public function index(int $limit): Response
    {
        return $this->render(
            'hello/index.html.twig',
            [
                'messages' => $this->messages,
                'limit' => $limit
            ]
        );
    }

    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne(int $id): Response
    {
        return $this->render(
            'hello/show_one.html.twig',
            [
                'messages' => $this->messages[$id]
            ]
        );
//        return new Response($this->messages[$id]);
    }
}