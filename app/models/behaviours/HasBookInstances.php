<?php

namespace App\Models\Behaviours;

use App\Models\BookInstance;
use Phalcon\Mvc\Model\Resultset;

/**
 * @property BookInstance[]|Resultset bookInstances
 * @method BookInstance[] getBookInstances
 */
trait HasBookInstances
{
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
