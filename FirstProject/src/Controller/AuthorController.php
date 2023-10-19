<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );
        return $this->render('author/index_auth.html.twig', [
            'controller_name' => 'AuthorController',
            'authors'=> $authors,
        ]);
    }

    #[Route('/author/new', name: 'app_author_new')]
    public function new(EntityManagerInterface $entityManagerInterface)
    {
        $author = new Author();
        $author -> setUsername("abc222");
        $author -> setEmail("abc222@abc.com22");
        $author -> setPicture("pic.jpg22");
        $author -> setNbBooks(20022);
        $entityManagerInterface -> persist($author);
        $entityManagerInterface -> flush();
        dump($author);
        die();
    }


#[Route('/author/edit/{id}',name:'app_author_edit')]
public function editAuthor($id,EntityManagerInterface $em,AuthorRepository $aR)
{
    
    $author = $aR->find($id);
    $author -> setEmail("email@modified.tn");
    $em ->persist($author);
    $em ->flush();
    dd($author);
}

#[Route('/author/delete/{id}',name:'app_author_delete')]
public function deleteAuthorr($id,EntityManagerInterface $em,AuthorRepository $aR)
{
    $author = $aR->find($id);
    $em ->remove($author);
    $em ->flush();
    return $this->redirectToRoute('app_author');
}

#[Route('/author/edit/{id}',name:'app_author_edit')]
public function editAuthorr($id,EntityManagerInterface $em,AuthorRepository $aR)
{
    
    $author = $aR->find($id);
    $author -> setEmail("email@modified.tn");
    $em ->persist($author);
    $em ->flush();
    dd($author);
}




#[Route('/author/form/new',name:'app_author_form_new')]
public function formAuthor(EntityManagerInterface $em,AuthorRepository $aR,Request $req)
{
    
    $author = new Author();
    $form=$this->createForm(AuthorType::class, $author);
    $form->handleRequest($req);
    if($form->isSubmitted()){
       $em ->persist($author);
       $em ->flush();
       return $this->redirectToRoute('app_author');
    }
    return $this->renderForm('author/addEditForm.html.twig' , ['formAdd' =>$form]);

}

}