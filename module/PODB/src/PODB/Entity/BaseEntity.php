<?php

namespace PODB\Entity;


class BaseEntity {

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
} 