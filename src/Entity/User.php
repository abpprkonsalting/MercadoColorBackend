<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Rollerworks\Component\PasswordStrength\Validator\Constraints as RollerworksPassword;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
        mode: 'html5'
        )]
    #[Assert\NotBlank(
        message: 'The email can not be empty.'
        )]
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    #[Assert\NotBlank(
        message: 'Password can not be empty.'
        )]
    // #[RollerworksPassword\PasswordStrength(
    //     minStrength:4
    //     )]
    #[RollerworksPassword\PasswordRequirements(
        minLength:8,
        requireLetters:true,
        requireNumbers:true, 
        requireCaseDiff:true,
        requireSpecialCharacter:true
        )]
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=ProductOffer::class, mappedBy="user")
     */
    private $productOffers;

    /**
     * @ORM\OneToMany(targetEntity=ProductOfferBid::class, mappedBy="user")
     */
    private $productOfferBids;

    /**
     * @ORM\OneToMany(targetEntity=UserInterchangeLocation::class, mappedBy="user", orphanRemoval=true)
     */
    private $userInterchangeLocations;

    public function __construct($email= null,$password = null)
    {
        if ($email != null) $this->setEmail($email);
        if ($password != null) $this->setPassword($password);
        $this->locations = new ArrayCollection();
        $this->productOffers = new ArrayCollection();
        $this->productOfferBids = new ArrayCollection();
        $this->userInterchangeLocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        $this->locations->removeElement($location);

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
            $productOffer->setUser($this);
        }

        return $this;
    }

    public function removeProductOffer(ProductOffer $productOffer): self
    {
        if ($this->productOffers->removeElement($productOffer)) {
            // set the owning side to null (unless already changed)
            if ($productOffer->getUser() === $this) {
                $productOffer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductOfferBid>
     */
    public function getProductOfferBids(): Collection
    {
        return $this->productOfferBids;
    }

    public function addProductOfferBid(ProductOfferBid $productOfferBid): self
    {
        if (!$this->productOfferBids->contains($productOfferBid)) {
            $this->productOfferBids[] = $productOfferBid;
            $productOfferBid->setUser($this);
        }

        return $this;
    }

    public function removeProductOfferBid(ProductOfferBid $productOfferBid): self
    {
        if ($this->productOfferBids->removeElement($productOfferBid)) {
            // set the owning side to null (unless already changed)
            if ($productOfferBid->getUser() === $this) {
                $productOfferBid->setUser(null);
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
            $userInterchangeLocation->setUser($this);
        }

        return $this;
    }

    public function removeUserInterchangeLocation(UserInterchangeLocation $userInterchangeLocation): self
    {
        if ($this->userInterchangeLocations->removeElement($userInterchangeLocation)) {
            // set the owning side to null (unless already changed)
            if ($userInterchangeLocation->getUser() === $this) {
                $userInterchangeLocation->setUser(null);
            }
        }

        return $this;
    }
}
