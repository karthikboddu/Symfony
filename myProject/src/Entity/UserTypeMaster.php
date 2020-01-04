<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTypeMasterRepository")
 */
class UserTypeMaster
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="fk_userType", orphanRemoval=true)
     */
    private $fk_userType;

    public function __construct()
    {
        $this->fk_userType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserType(): ?string
    {
        return $this->user_type;
    }

    public function setUserType(string $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFkUserType(): Collection
    {
        return $this->fk_userType;
    }

    public function addFkUserType(User $fkUserType): self
    {
        if (!$this->fk_userType->contains($fkUserType)) {
            $this->fk_userType[] = $fkUserType;
            $fkUserType->setFkUserType($this);
        }

        return $this;
    }

    public function removeFkUserType(User $fkUserType): self
    {
        if ($this->fk_userType->contains($fkUserType)) {
            $this->fk_userType->removeElement($fkUserType);
            // set the owning side to null (unless already changed)
            if ($fkUserType->getFkUserType() === $this) {
                $fkUserType->setFkUserType(null);
            }
        }

        return $this;
    }

}
