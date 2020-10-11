<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class WeaponSearch
{
    /**
     *
     * @var string|null
     */
    private $searchName;
    
    /**
     *
     * @var string|null
     * @Assert\Regex("/^[0-9]{4}$/")
     */
    private $searchDate;

    public function __construct()
    {
    }

    /**
     * Get the value of searchDate
     *
     * @return  string|null
     */ 
    public function getSearchDate()
    {
        return $this->searchDate;
    }

    /**
     * Set the value of searchDate
     *
     * @param  string|null  $searchDate
     *
     * @return  self
     */ 
    public function setSearchDate($searchDate)
    {
        $this->searchDate = $searchDate;

        return $this;
    }

    /**
     * Get the value of searchName
     *
     * @return  string|null
     */ 
    public function getSearchName()
    {
        return $this->searchName;
    }

    /**
     * Set the value of searchName
     *
     * @param  string|null  $searchName
     *
     * @return  self
     */ 
    public function setSearchName($searchName)
    {
        $this->searchName = $searchName;

        return $this;
    }
}