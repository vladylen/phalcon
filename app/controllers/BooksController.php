<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\BookInstance;
use App\Models\User;
use Phalcon\Http\Response;
use Phalcon\Mvc\Model\Query\StatusInterface;

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
        $phql  = /** @lang text */
            "SELECT * FROM App\\Models\\Book ORDER BY name";
        $books = $this->modelsManager->executeQuery($phql);

        $response = new Response();

        $data = [];
        foreach ($books as $book) {
            $data[] = [
                'id'   => $book->id,
                'name' => $book->name
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
        $phql  = /** @lang text */
            "SELECT * FROM App\\Models\\Book WHERE name LIKE :name: ORDER BY name";
        /** @var Book[] $books */
        $books = $this->modelsManager->executeQuery(
            $phql,
            [
                'name' => '%' . $name . '%'
            ]
        );

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
        $phql = /** @lang text */
            "SELECT * FROM App\\Models\\Book WHERE id = :id:";
        /** @var \Phalcon\Mvc\Model\Resultset $result */
        /** @var Book $book */
        $result = $this->modelsManager->executeQuery($phql, ['id' => $id]);
        $book   = $result->getFirst();

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
        $book = $this->request->getJsonRawBody();

        $phql = /** @lang text */
            "INSERT INTO App\\Models\\Book (name, description) VALUES (:name:, :description:)";

        /** @var StatusInterface $status */
        $status = $this->modelsManager->executeQuery(
            $phql,
            [
                'name'        => $book->name,
                'description' => $book->description,
            ]
        );

        $response = new Response();

        if ($status->success() === true) {
            $book->id = $status->getModel()->id;

            $response->setStatusCode(201, "Created");
            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $book
                ]
            );
        } else {
            $this->createErrorResponse($response, $status);
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
        $book = $this->request->getJsonRawBody();

        $phql = /** @lang text */
            "UPDATE App\\Models\\Book SET name = :name:, description = :description: WHERE id = :id:";
        /** @var StatusInterface $status */
        $status = $this->modelsManager->executeQuery(
            $phql,
            [
                'id'          => $id,
                'name'        => $book->name,
                'description' => $book->description,
            ]
        );

        $response = new Response();

        if ($status->success() == true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            $this->createErrorResponse($response, $status);
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
        $phql = /** @lang text */
            "DELETE FROM App\\Models\\Book WHERE id = :id:";
        /** @var StatusInterface $status */
        $status = $this->modelsManager->executeQuery(
            $phql,
            [
                'id' => $id
            ]
        );

        $response = new Response();

        if ($status->success() == true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            $this->createErrorResponse($response, $status);
        }

        return $response;
    }

    /**
     * @param Response        $response
     * @param StatusInterface $status
     */
    private function createErrorResponse(Response $response, StatusInterface $status)
    {
        $response->setStatusCode(409, "Conflict");

        $errors = [];
        foreach ($status->getMessages() as $message) {
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

