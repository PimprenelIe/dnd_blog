<?php


namespace App\Helper;


use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Adds created by and updated by user to entities.
 * Entities using this must have HasLifecycleCallbacks annotation.
 */
trait Userable
{
    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $createdBy;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $updatedBy;

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}