<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
    
    /**
     *
     * @var ArrayCollection
     */
    private $searchOptions;


    public function __construct()
    {
        $this->searchOptions = new ArrayCollection();
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

    /**
     * Get the value of searchOptions
     *
     * @return  ArrayCollection
     */ 
    public function getSearchOptions()
    {
        return $this->searchOptions;
    }

    /**
     * Set the value of searchOptions
     *
     * @param  ArrayCollection  $searchOptions
     *
     * @return  self
     */ 
    public function setSearchOptions(ArrayCollection $searchOptions)
    {
        $this->searchOptions = $searchOptions;

        return $this;
    }
}