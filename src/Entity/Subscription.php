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
}
