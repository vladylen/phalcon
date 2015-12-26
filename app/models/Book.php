<?php

namespace App\Models;

use App\Models\Behaviours\HasBookInstances;

class Book extends BaseModel
{
    use HasBookInstances;

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
}
