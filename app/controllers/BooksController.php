<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\BookInstance;
use App\Models\User;
use Phalcon\Http\Response;
use Phalcon\Mvc\ModelInterface;

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
        /** @var Book[] $books */
        $books = Book::find();

        $response = new Response();

        $data = [];
        foreach ($books as $book) {
            $data[] = [
                'id'   => $book->getId(),
                'name' => $book->getName()
            ];
        }

        return $response->setJsonContent($data);
    }

    /**
     * @Get("/search/{name}")
     *
     * @param $name
     *
     * @return Response
     */
    public function searchAction($name)
    {
        /** @var Book[] $books */
        $books = Book::find(["name LIKE '%$name%'"]);

        $response = new Response();

        $data = [];
        foreach ($books as $book) {
            $data[] = [
                'id'   => $book->getId(),
                'name' => $book->getName()
            ];
        }

        return $response->setJsonContent($data);
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
        /** @var Book $book */
        $book = Book::findFirst(['id' => $id]);

        $response = new Response();

        if ($book === false) {
            $response->setJsonContent(['status' => 'NOT-FOUND']);
        } else {
            $response->setJsonContent(
                [
                    'status' => 'FOUND',
                    'data'   => [
                        'id'   => $book->getId(),
                        'name' => $book->getName()
                    ]
                ]
            );
        }

        return $response;
    }

    /**
     * @Post("/")
     *
     * @return Response
     */
    public function addAction()
    {
        $bookData = $this->request->getJsonRawBody();

        $book = new Book();
        $book->setName($bookData->name);
        $book->setDescription($bookData->description);

        $response = new Response();

        if ($book->save() === true) {
            $response->setStatusCode(201, "Created");
            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $book->getId()
                ]
            );
        } else {
            $this->createErrorResponse($response, $book);
        }

        return $response;
    }

    /**
     * @Put("/{id:[0-9]+}")
     *
     * @param $id
     *
     * @return Response
     */
    public function updateAction($id)
    {
        $bookData = $this->request->getJsonRawBody();

        /** @var Book $book */
        $book = Book::findFirst(['id' => $id]);
        $book->setName($bookData->name);
        $book->setDescription($bookData->description);

        $response = new Response();

        if ($book->save() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            $this->createErrorResponse($response, $book);
        }

        return $response;
    }

    /**
     * @Delete("/{id:[0-9]+}")
     *
     * @param $id
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        /** @var Book $book */
        $book = Book::findFirst(['id' => $id]);

        $response = new Response();

        if ($book->delete() === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            $this->createErrorResponse($response, $book);
        }

        return $response;
    }

    /**
     * @param Response       $response
     * @param ModelInterface $book
     */
    private function createErrorResponse(Response $response, ModelInterface $book)
    {
        $response->setStatusCode(409, "Conflict");

        $errors = [];
        foreach ($book->getMessages() as $message) {
            $errors[] = $message->getMessage();
        }

        $response->setJsonContent(
            [
                'status'   => 'ERROR',
                'messages' => $errors
            ]
        );
    }

    public function someAction()
    {
        $book = new Book();
        $book->setName('name');
        $book->setDescription('description');
        $book->save();
        $user = new User();
        $user->setName('name');
        $user->setEmail('test@email.com');
        $user->save();

        var_dump($book->getMessages());
        var_dump($user->getMessages());

        /** @var Book $book */
        /** @var User $user */
        $book            = Book::findFirst(1);
        $user            = User::findFirst(1);
        $bookInstanceNew = new BookInstance();
        $book->addBookInstance($bookInstanceNew);
        $book->save();
        $user->addBookInstance($bookInstanceNew);
        $user->save();

        foreach ($book->getBookInstances() as $bookInstance) {
            var_dump($bookInstance->getId());
            var_dump($bookInstance->getBook()->getId());
        }

        throw new \Exception();
    }
}

