<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileExplorerRepository")
 */
class FileExplorer
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
    private $fid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isfolder;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $parent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserPostUpload", mappedBy="fk_user_folder")
     */
    private $fk_user_folder;

    public function __construct()
    {
        $this->fk_user_folder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFid(): ?string
    {
        return $this->fid;
    }

    public function setFid(string $fid): self
    {
        $this->fid = $fid;

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

    public function getIsfolder():  ?bool
    {
        return $this->isfolder;
    }

    public function setIsfolder(bool $isfolder): self
    {
        $this->isfolder = $isfolder;

        return $this;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(string $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * @return Collection|UserPostUpload[]
     */
    public function getFkUserFolder(): Collection
    {
        return $this->fk_user_folder;
    }

    public function addFkUserFolder(UserPostUpload $fkUserFolder): self
    {
        if (!$this->fk_user_folder->contains($fkUserFolder)) {
            $this->fk_user_folder[] = $fkUserFolder;
            $fkUserFolder->setFkUserFolder($this);
        }

        return $this;
    }

    public function removeFkUserFolder(UserPostUpload $fkUserFolder): self
    {
        if ($this->fk_user_folder->contains($fkUserFolder)) {
            $this->fk_user_folder->removeElement($fkUserFolder);
            // set the owning side to null (unless already changed)
            if ($fkUserFolder->getFkUserFolder() === $this) {
                $fkUserFolder->setFkUserFolder(null);
            }
        }

        return $this;
    }
}
