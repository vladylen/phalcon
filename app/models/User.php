<?php

namespace App\Models;

use Phalcon\Mvc\Model\Resultset;

/**
 * @property BookInstance[]|Resultset bookInstances
 * @method getBookInstances
 */
class User extends BaseModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    public function initialize()
    {
        parent::initialize();

        $this->setSource('users');
        $this->hasMany('id', "App\\Models\\BookInstance", 'user_id', ["alias" => "bookInstances"]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param BookInstance $newBookInstance
     */
    public function addBookInstance(BookInstance $newBookInstance)
    {
        $isNew = true;

        if (!is_null($newBookInstance->getId())) {
            foreach ($this->bookInstances as $bookInstance) {
                if ($bookInstance->getId() === $newBookInstance->getId()) {
                    $isNew = false;
                    break;
                }
            }
        }

        if ($isNew === true) {
            $this->bookInstances = $newBookInstance;
        }
    }

    /**
     * @param BookInstance[]|null $bookInstances
     */
    public function setBookInstances(array $bookInstances = null)
    {
        $this->bookInstances->delete();
        $this->bookInstances = $bookInstances;
    }
}
