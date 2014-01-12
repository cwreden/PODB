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
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var
     * @Column(type="string")
     */
    protected $locale;

    /**
     * @var
     * @ManyToOne(targetEntity="User")
     */
    protected $createdBy;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $createDate;

    /**
     * @var
     * @ManyToOne(targetEntity="User")
     */
    protected $lastUpdateBy;

    /**
     * @var
     * @Column(type="datetime")
     */
    protected $lastUpdateDate;

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
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return DateTime|null
     */
    public function getCreateDate()
    {
        return $this->createDate ? clone $this->createDate : null;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate ? clone $this->lastUpdateDate : null;
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
     * @param DateTime $createDate
     */
    public function setCreateDate(DateTime $createDate = null)
    {
        $this->createDate = $createDate ? clone $createDate : null;
    }

    /**
     * @param DateTime $lastUpdateDate
     */
    public function setLastUpdateDate(DateTime $lastUpdateDate = null)
    {
        $this->lastUpdateDate = $lastUpdateDate ? clone $lastUpdateDate : null;
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param string $lastUpdateBy
     */
    public function setLastUpdateBy($lastUpdateBy)
    {
        $this->lastUpdateBy = $lastUpdateBy;
    }

    /**
     * @return string
     */
    public function getLastUpdateBy()
    {
        return $this->lastUpdateBy;
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
            'createdBy' => $this->getCreatedBy(),
            'createDate' => $this->getCreateDate(),
            'lastUpdatedBy' => $this->getLastUpdateBy(),
            'lastUpdateDate' => $this->getLastUpdateDate(),
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
        $this->setLastUpdateDate(new DateTime());
    }
} 