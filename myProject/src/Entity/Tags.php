<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagsRepository")
 */
class Tags
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
    private $created;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="posttag")
     */
    private $tagpost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="usertags")
     */
    private $taguser;

    public function __construct()
    {
        $this->tagpost = new ArrayCollection();
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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getTagpost(): Collection
    {
        return $this->tagpost;
    }

    public function addTagpost(Post $tagpost): self
    {
        if (!$this->tagpost->contains($tagpost)) {
            $this->tagpost[] = $tagpost;
            $tagpost->setPosttag($this);
        }

        return $this;
    }

    public function removeTagpost(Post $tagpost): self
    {
        if ($this->tagpost->contains($tagpost)) {
            $this->tagpost->removeElement($tagpost);
            // set the owning side to null (unless already changed)
            if ($tagpost->getPosttag() === $this) {
                $tagpost->setPosttag(null);
            }
        }

        return $this;
    }

    public function getTaguser(): ?User
    {
        return $this->taguser;
    }

    public function setTaguser(?User $taguser): self
    {
        $this->taguser = $taguser;

        return $this;
    }
}
