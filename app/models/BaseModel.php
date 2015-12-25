<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class BaseModel extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     *
     * @var int
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    public function initialize()
    {
        $this->addBehavior(
            new Model\Behavior\Timestampable(
                [
                    'beforeCreate' => [
                        'field'  => 'created_at',
                        'format' => 'Y-m-d H:i:s'
                    ],
                    'beforeUpdate' => [
                        'field'  => 'updated_at',
                        'format' => 'Y-m-d H:i:s'
                    ]
                ]
            )
        );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
