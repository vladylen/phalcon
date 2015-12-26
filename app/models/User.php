<?php

namespace App\Models;

use App\Models\Behaviours\HasBookInstances;

class User extends BaseModel
{
    use HasBookInstances;

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
}
