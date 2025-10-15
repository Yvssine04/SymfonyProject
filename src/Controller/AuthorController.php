<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[route('/showAll',name:'ShowAll')]
    public function ShowAll(AuthorRepository $repo){
    $authors=$repo->findAll();
        return $this->render('author/showAll.html.twig',['list'=>$authors]);
    }

    #[route('/addStat',name:'addStat')]
    public function addStat(ManagerRegistry $doctrine){
        $author=new Author();
        $author->setEmail(email: 'foulen5@gmail.com');
        $author->setUsername(username: 'foulen5');
        $em=$doctrine->getManager();
        $em->persist($author);
        $em->flush();

        //return new response("Author aadded succesfully")
        return $this->redirectToRoute('ShowAll');
    
    }


     #[Route('/deleteAuthor/{id}',name:'deleteAuthor')]
    public function deleteAuthor($id,AuthorRepository $repo,ManagerRegistry $manager){
          $author=$repo->find($id);
          $em=$manager->getManager();
          $em->remove($author);
          $em->flush();
          return $this->redirectToRoute('ShowAll');
    }

    #[Route('/showAuthorDetails/{id}',name:'showAuthorDetails')]
    public function showAuthorDetails($id, AuthorRepository $repo){
     $author=$repo->find($id);
     return $this->render('author/showDetails.html.twig',['author'=>$author]);
    }

    #[Route('/addform', name:'addForm')]
    public function addform(ManagerRegistry $doctrine)
    {
     $author = new Author();
    $form = $this->createForm(AuthorType::class, $author);
    $form->add('Ajouter', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);
    $form->handleRequest(\Symfony\Component\HttpFoundation\Request::createFromGlobals());

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->persist($author);
        $em->flush();
    }
    return $this->render('author/addform.html.twig', [
        'formAuthor' => $form->createView()
    ]);
    }

    #[Route('/updateform/{id}', name:'updateForm')]
    public function updateform(ManagerRegistry $doctrine, Request $request, $id)
    {
     $author = $doctrine->getRepository(Author::class)->find($id);
    $form = $this->createForm(AuthorType::class, $author);
    $form->add('Modifier', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->flush();
        return $this->redirectToRoute('ShowAll');
    }
    return $this->render('author/updateform.html.twig', [
        'formAuthor' => $form->createView()
    ]);
    }




}