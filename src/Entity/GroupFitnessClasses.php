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
     * @ORM\OneToMany(targetEntity=Subscription::class, mappedBy="groupFitnessClass", orphanRemoval=true)
     */
    private $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
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
     * @return Collection|Subscription[]
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): self
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions[] = $subscription;
            $subscription->setGroupFitnessClass($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): self
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getGroupFitnessClass() === $this) {
                $subscription->setGroupFitnessClass(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getEmailSubscriptions(): Collection
    {
        return $this->getSubscriptions()->filter(
            fn(Subscription $subscription) => $subscription->getContactType()->getCode() == 'email'
        );
    }

    /**
     * @return Collection|Subscription[]
     */
    public function getSmsSubscriptions(): Collection
    {
        return $this->getSubscriptions()->filter(
            fn(Subscription $subscription) => $subscription->getContactType()->getCode() == 'phone'
        );
    }
}
