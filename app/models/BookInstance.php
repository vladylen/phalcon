<?php

namespace App\Models;

/**
 * @property Book book
 * @method getBook
 */
class BookInstance extends BaseModel
{
    /**
     * @var int
     */
    private $book_id;

    /**
     * @var string
     */
    private $user_id;

    public function initialize()
    {
        parent::initialize();

        $this->setSource('book_instances');
        $this->belongsTo('book_id', "App\\Models\\Book", 'id', ["alias" => "book"]);
        $this->belongsTo('user_id', "App\\Models\\User", 'id', ["alias" => "user"]);
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param string $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * @return int
     */
    public function getBookId()
    {
        return $this->book_id;
    }

    /**
     * @param int $bookId
     */
    public function setBookId($bookId)
    {
        $this->book_id = $bookId;
    }
}
