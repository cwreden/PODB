<?php

namespace OpenCoders\Podb\Persistence\Entity;

use DateTime;
use OpenCoders\Podb\Exception\EmptyParameterException;
use OpenCoders\Podb\Exception\PodbException;

/**
 * Class Language
 * @package OpenCoders\Podb\Persistence\Entity
 * @Entity(repositoryClass="OpenCoders\Podb\Persistence\Repository\LanguageRepository")
 */
class Language extends AbstractBaseEntity
{

    /**
     * @var
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $name;

    /**
     * @var
     * @Column(type="string", unique=true, nullable=false)
     */
    protected $locale;

    /**
     * @var
     * @ManyToMany(targetEntity="User", mappedBy="supportedLanguages")
     * @JoinTable(name="users_languages")
     */
    protected $supportedBy;

    /**
     * @return
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @return DateTime|null
     */
    public function getCreateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdateDate()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param string $name
     *
     * @throws \OpenCoders\Podb\Exception\EmptyParameterException
     */
    public function setName($name)
    {
        if ($name == null || $name == '') {
            throw new EmptyParameterException('Name not allowed to be empty.');
        }
        $this->name = $name;
    }

    /**
     * @param string $locale
     *
     * @throws \OpenCoders\Podb\Exception\EmptyParameterException
     */
    public function setLocale($locale)
    {
        if ($locale == null || $locale == '') {
            throw new EmptyParameterException('Locale not allowed to be empty.');
        }
        $this->locale = $locale;
    }

    /**
     * @return User
     */
    public function getLastUpdateBy()
    {
        throw new \Exception('Not implemented!');
    }

    /**
     * @param mixed $supportedBy
     */
    public function setSupportedBy($supportedBy)
    {
        $this->supportedBy = $supportedBy;
    }

    /**
     * @return mixed
     */
    public function getSupportedBy()
    {
        return $this->supportedBy;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'locale' => $this->getLocale(),
//            'createdBy' => $createdBy,
//            'createDate' => $this->getCreateDate(),
//            'lastUpdatedBy' => $updatedBy,
//            'lastUpdateDate' => $this->getLastUpdateDate(),
        );
    }

    /**
     * @return array
     */
    public function asShortArray()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
        );
    }

    public function getAPIInformation($apiVersion)
    {
        $apiBaseUrl = $this->getBaseAPIUrl();

        return array(
            'url' => $apiBaseUrl . '/' . $apiVersion . '/languages/' . $this->getLocale(),
//            'url_projects' => $apiBaseUrl . '/' . $apiVersion . '/languages/' . $this->getLocale() . '/projects'
        );
    }

    public function update($data)
    {
        if ($data == null) {
            throw new PodbException('There is nothing to update.');
        }
        foreach ($data as $key => $value) {
            if ($key == 'name') {
                $this->setName($value);
            } else if ($key == 'locale') {
                $this->setLocale($value);
            }
        }
    }
} 