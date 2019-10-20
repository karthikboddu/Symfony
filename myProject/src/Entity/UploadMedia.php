<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UploadMediaRepository")
 */
class UploadMedia
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
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UploadMediaType", mappedBy="MediaUploadName", orphanRemoval=true)
     */
    private $uploadMedia;

    public function __construct()
    {
        $this->uploadMedia = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|UploadMediaType[]
     */
    public function getUploadMedia(): Collection
    {
        return $this->uploadMedia;
    }

    public function addUploadMedium(UploadMediaType $uploadMedium): self
    {
        if (!$this->uploadMedia->contains($uploadMedium)) {
            $this->uploadMedia[] = $uploadMedium;
            $uploadMedium->setMediaUploadName($this);
        }

        return $this;
    }

    public function removeUploadMedium(UploadMediaType $uploadMedium): self
    {
        if ($this->uploadMedia->contains($uploadMedium)) {
            $this->uploadMedia->removeElement($uploadMedium);
            // set the owning side to null (unless already changed)
            if ($uploadMedium->getMediaUploadName() === $this) {
                $uploadMedium->setMediaUploadName(null);
            }
        }

        return $this;
    }
}
