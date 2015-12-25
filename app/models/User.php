<?php

namespace App\Models;

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

        $this->hasMany('id', "App\\Models\\BookInstance", 'user_id');
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
