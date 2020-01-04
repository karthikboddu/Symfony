<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tags", inversedBy="tagpost")
     */
    private $posttag;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $posturl;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UploadMediaType", inversedBy="mediaUploadType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mediaTypeUpload;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserPostUpload", mappedBy="fk_post_id")
     */
    private $fk_post_userpostupload;

    public function __construct()
    {
        $this->postfile = new ArrayCollection();
        $this->fk_post_userpostupload = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getPosttag(): ?Tags
    {
        return $this->posttag;
    }

    public function setPosttag(?Tags $posttag): self
    {
        $this->posttag = $posttag;

        return $this;
    }

    public function getPosturl(): ?string
    {
        return $this->posturl;
    }

    public function setPosturl(string $posturl): self
    {
        $this->posturl = $posturl;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMediaTypeUpload(): ?UploadMediaType
    {
        return $this->mediaTypeUpload;
    }

    public function setMediaTypeUpload(?UploadMediaType $mediaTypeUpload): self
    {
        $this->mediaTypeUpload = $mediaTypeUpload;

        return $this;
    }

    /**
     * @return Collection|UserPostUpload[]
     */
    public function getFkPostUserpostupload(): Collection
    {
        return $this->fk_post_userpostupload;
    }

    public function addFkPostUserpostupload(UserPostUpload $fkPostUserpostupload): self
    {
        if (!$this->fk_post_userpostupload->contains($fkPostUserpostupload)) {
            $this->fk_post_userpostupload[] = $fkPostUserpostupload;
            $fkPostUserpostupload->setFkPostId($this);
        }

        return $this;
    }

    public function removeFkPostUserpostupload(UserPostUpload $fkPostUserpostupload): self
    {
        if ($this->fk_post_userpostupload->contains($fkPostUserpostupload)) {
            $this->fk_post_userpostupload->removeElement($fkPostUserpostupload);
            // set the owning side to null (unless already changed)
            if ($fkPostUserpostupload->getFkPostId() === $this) {
                $fkPostUserpostupload->setFkPostId(null);
            }
        }

        return $this;
    }
}
