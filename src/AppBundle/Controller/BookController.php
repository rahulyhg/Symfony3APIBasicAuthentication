<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Book;
use AppBundle\Form\BookType;

class BookController extends FOSRestController
{
    public function getBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository(Book::class)->findAll();

        if (!$books) {
            throw new HttpException(400, "Invalid data");
        }

        return $books;
    }

    public function getBookAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }

        return $book;
    }

    public function postBookAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $book;
        }

        throw new HttpException(400, "Invalid data");
    }

    public function putBookAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);

        $form = $this->createForm(BookType::class, $book, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($book);
            $em->flush();

            return $book;
        }

        throw new HttpException(400, "Invalid data");
    }

    public function deleteBookAction($id)
    {
        if (!$id) {
            throw new HttpException(400, "Invalid id");
        }

        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository(Book::class)->find($id);
        $em->remove($book);
        $em->flush();

        return $book;
    }
}
