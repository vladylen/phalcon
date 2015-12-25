<?php

namespace App\Controllers;

use App\Models\Books;

/**
 * @RoutePrefix("/api/books")
 */
class BooksController extends ControllerBase
{
    /**
     * @Get("/")
     *
     * @return \Phalcon\Http\Response
     */
    public function indexAction()
    {
        $response = new \Phalcon\Http\Response();

        return $response->setJsonContent(['some_key' => 1]);
    }

    /**
     * @Get("/{id:[0-9]+}")
     *
     * @param $id
     *
     * @return \Phalcon\Http\Response
     */
    public function viewAction($id)
    {
        $test = new Books();
        $response = new \Phalcon\Http\Response();

        return $response->setJsonContent(['some_key' => $id]);
    }
}

