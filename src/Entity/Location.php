<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="childrenLocations")
     */
    private $parentLocation;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="parentLocation")
     */
    private $childrenLocations;

    /**
     * @ORM\OneToMany(targetEntity=ProductAttributeValueInt::class, mappedBy="location")
     */
    private $productAttributeValueInts;

    /**
     * @ORM\OneToMany(targetEntity=ProductAttributeValueString::class, mappedBy="location", orphanRemoval=true)
     */
    private $productAttributeValueStrings;

    /**
     * @ORM\OneToMany(targetEntity=ProductOffer::class, mappedBy="location")
     */
    private $productOffers;

    /**
     * @ORM\OneToMany(targetEntity=UserInterchangeLocation::class, mappedBy="location", orphanRemoval=true)
     */
    private $userInterchangeLocations;

    public function __construct()
    {
        $this->childrenLocations = new ArrayCollection();
        $this->productAttributeValueInts = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->productAttributeValueStrings = new ArrayCollection();
        $this->productOffers = new ArrayCollection();
        $this->userInterchangeLocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParentLocation(): ?self
    {
        return $this->parentLocation;
    }

    public function setParentLocation(?self $parentLocation): self
    {
        $this->parentLocation = $parentLocation;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildrenLocations(): Collection
    {
        return $this->childrenLocations;
    }

    public function addChildrenLocation(self $childrenLocation): self
    {
        if (!$this->childrenLocations->contains($childrenLocation)) {
            $this->childrenLocations[] = $childrenLocation;
            $childrenLocation->setParentLocation($this);
        }

        return $this;
    }

    public function removeChildrenLocation(self $childrenLocation): self
    {
        if ($this->childrenLocations->removeElement($childrenLocation)) {
            // set the owning side to null (unless already changed)
            if ($childrenLocation->getParentLocation() === $this) {
                $childrenLocation->setParentLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductAttributeValueInt>
     */
    public function getProductAttributeValueInts(): Collection
    {
        return $this->productAttributeValueInts;
    }

    public function addProductAttributeValueInt(ProductAttributeValueInt $productAttributeValueInt): self
    {
        if (!$this->productAttributeValueInts->contains($productAttributeValueInt)) {
            $this->productAttributeValueInts[] = $productAttributeValueInt;
            $productAttributeValueInt->setLocation($this);
        }

        return $this;
    }

    public function removeProductAttributeValueInt(ProductAttributeValueInt $productAttributeValueInt): self
    {
        if ($this->productAttributeValueInts->removeElement($productAttributeValueInt)) {
            // set the owning side to null (unless already changed)
            if ($productAttributeValueInt->getLocation() === $this) {
                $productAttributeValueInt->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addLocation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeLocation($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductAttributeValueString>
     */
    public function getProductAttributeValueStrings(): Collection
    {
        return $this->productAttributeValueStrings;
    }

    public function addProductAttributeValueString(ProductAttributeValueString $productAttributeValueString): self
    {
        if (!$this->productAttributeValueStrings->contains($productAttributeValueString)) {
            $this->productAttributeValueStrings[] = $productAttributeValueString;
            $productAttributeValueString->setLocation($this);
        }

        return $this;
    }

    public function removeProductAttributeValueString(ProductAttributeValueString $productAttributeValueString): self
    {
        if ($this->productAttributeValueStrings->removeElement($productAttributeValueString)) {
            // set the owning side to null (unless already changed)
            if ($productAttributeValueString->getLocation() === $this) {
                $productAttributeValueString->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductOffer>
     */
    public function getProductOffers(): Collection
    {
        return $this->productOffers;
    }

    public function addProductOffer(ProductOffer $productOffer): self
    {
        if (!$this->productOffers->contains($productOffer)) {
            $this->productOffers[] = $productOffer;
            $productOffer->setLocation($this);
        }

        return $this;
    }

    public function removeProductOffer(ProductOffer $productOffer): self
    {
        if ($this->productOffers->removeElement($productOffer)) {
            // set the owning side to null (unless already changed)
            if ($productOffer->getLocation() === $this) {
                $productOffer->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserInterchangeLocation>
     */
    public function getUserInterchangeLocations(): Collection
    {
        return $this->userInterchangeLocations;
    }

    public function addUserInterchangeLocation(UserInterchangeLocation $userInterchangeLocation): self
    {
        if (!$this->userInterchangeLocations->contains($userInterchangeLocation)) {
            $this->userInterchangeLocations[] = $userInterchangeLocation;
            $userInterchangeLocation->setLocation($this);
        }

        return $this;
    }

    public function removeUserInterchangeLocation(UserInterchangeLocation $userInterchangeLocation): self
    {
        if ($this->userInterchangeLocations->removeElement($userInterchangeLocation)) {
            // set the owning side to null (unless already changed)
            if ($userInterchangeLocation->getLocation() === $this) {
                $userInterchangeLocation->setLocation(null);
            }
        }

        return $this;
    }
}
