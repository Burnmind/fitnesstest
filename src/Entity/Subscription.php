<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriptionRepository::class)
 */
class Subscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SubscriptionContact::class, inversedBy="subscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contactType;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="subscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subscribedUser;

    /**
     * @ORM\ManyToOne(targetEntity=GroupFitnessClasses::class, inversedBy="subscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupFitnessClass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactType(): ?SubscriptionContact
    {
        return $this->contactType;
    }

    public function setContactType(?SubscriptionContact $contactType): self
    {
        $this->contactType = $contactType;

        return $this;
    }

    public function getSubscribedUser(): ?User
    {
        return $this->subscribedUser;
    }

    public function setSubscribedUser(?User $subscribedUser): self
    {
        $this->subscribedUser = $subscribedUser;

        return $this;
    }

    public function getGroupFitnessClass(): ?GroupFitnessClasses
    {
        return $this->groupFitnessClass;
    }

    public function setGroupFitnessClass(?GroupFitnessClasses $groupFitnessClass): self
    {
        $this->groupFitnessClass = $groupFitnessClass;

        return $this;
    }
}
