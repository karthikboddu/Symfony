<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=255)
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

    public function getIsfolder(): ?string
    {
        return $this->isfolder;
    }

    public function setIsfolder(string $isfolder): self
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
}
