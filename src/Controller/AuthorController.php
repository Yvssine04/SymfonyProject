<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/show/{name}', name: 'showAuthor')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'nom' => $name,
            'prenom' => 'ben foulen'
        ]);
    }

    #[Route('/authors', name: 'list_authors')]
    public function listAuthors(): Response
    {
        $authors = [
            ['id' => 1, 'picture' => '/assets/images/1.png', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            ['id' => 2, 'picture' => '/assets/images/2.png', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            ['id' => 3, 'picture' => '/assets/images/3.png', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];

        return $this->render('author/list.html.twig', [
            'authors' => $authors
        ]);
    }

    #[Route('/author/details/{id}', name: 'author_details')]
    public function authorDetails($id): Response
    {
        $authors = [
            1 => ['id' => 1, 'picture' => '/assets/images/1.png', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
            2 => ['id' => 2, 'picture' => '/assets/images/2.png', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
            3 => ['id' => 3, 'picture' => '/assets/images/3.png', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
        ];

        $author = $authors[$id] ?? null;

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author
        ]);
    }
}
