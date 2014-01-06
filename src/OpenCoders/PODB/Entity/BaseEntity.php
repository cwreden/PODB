<?php

namespace OpenCoders\PODB\Entity;


class BaseEntity {

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
} 