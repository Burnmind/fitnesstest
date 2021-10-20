<?php

namespace App\Entity;

use App\Repository\GroupFitnessClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupFitnessClassesRepository::class)
 */
class GroupFitnessClasses
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
     * @ORM\Column(type="string", length=255)
     */
    private $couchName;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="subscription")
     */
    private $subscribedUsers;

    public function __construct()
    {
        $this->subscribedUsers = new ArrayCollection();
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

    public function getCouchName(): ?string
    {
        return $this->couchName;
    }

    public function setCouchName(string $couchName): self
    {
        $this->couchName = $couchName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSubscribedUsers(): Collection
    {
        return $this->subscribedUsers;
    }

    public function addSubscribedUser(User $subscribedUser): self
    {
        if (!$this->subscribedUsers->contains($subscribedUser)) {
            $this->subscribedUsers[] = $subscribedUser;
            $subscribedUser->addSubscription($this);
        }

        return $this;
    }

    public function removeSubscribedUser(User $subscribedUser): self
    {
        if ($this->subscribedUsers->removeElement($subscribedUser)) {
            $subscribedUser->removeSubscription($this);
        }

        return $this;
    }
}
