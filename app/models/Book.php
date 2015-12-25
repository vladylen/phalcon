<?php

namespace App\Models;

use Phalcon\Mvc\Model\Resultset;

/**
 * @property BookInstance[]|Resultset bookInstances
 * @method getBookInstances
 */
class Book extends BaseModel
{
    /**
     * @Column(name="description", type="string", length="255", nullable=true)
     *
     * @var string
     */
    private $name;

    /**
     * @Column(name="description", type="string", length="255", nullable=true)
     *
     * @var string
     */
    private $description;

    public function initialize()
    {
        parent::initialize();

        $this->setSource('books');
        $this->hasMany('id', "App\\Models\\BookInstance", 'book_id', ["alias" => "bookInstances"]);
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
