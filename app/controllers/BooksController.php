<?php

namespace App\Controllers;

use App\Models\BookInstance;
use App\Models\Book;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Http\Response;

/**
 * @RoutePrefix("/api/books")
 */
class BooksController extends ControllerBase
{
    /**
     * @Get("/")
     *
     * @return Response
     */
    public function indexAction()
    {
        $response = new Response();

        return $response->setJsonContent(['some_key' => 1]);
    }

    /**
     * @Get("/{id:[0-9]+}")
     *
     * @param $id
     *
     * @return Response
     */
    public function viewAction($id)
    {
        $book = new Book();
        $book->setName('name');
        $book->setDescription('description');
        $book->save();

        $bookInstanceNew = new BookInstance();
        $bookInstanceNew->setBookId($book->getId());

        var_dump($book->getMessages());
        var_dump($bookInstanceNew->getMessages());


        /** @var Book $book */
        $book = Book::findFirst(1);

        /** @var BookInstance $bookInstance */
        foreach ($book->getBookInstances() as $bookInstance) {
            var_dump($bookInstance->getId());
            var_dump($bookInstance->getBook()->getId());
        }

        throw new \Exception();

        $response = new Response();

        return $response->setJsonContent($book);
    }
}

