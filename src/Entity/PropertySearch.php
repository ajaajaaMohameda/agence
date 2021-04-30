<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
class PropertySearch
{
    /**
     * Undocumented variable
     *
     * @var int|null
     */
    private $maxPrice;

    /**
     * Undocumented variable
     * @Assert\Range(min=10, max=400)
     *
     * @var int|null
     */
    private $minSurface;

    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {   
        $this->options = new ArrayCollection();
    }

    /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * Undocumented function
     *
     * @param integer $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

        /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * Undocumented function
     *
     * @param integer $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }
    /**
     * Undocumented function
     *
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;
    }

}