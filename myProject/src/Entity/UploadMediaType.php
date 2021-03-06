<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UploadMediaTypeRepository")
 */
class UploadMediaType
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
     * @ORM\Column(type="string", length=255)
     */
    private $mediaType;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UploadMedia", inversedBy="uploadMedia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $MediaUploadName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FileUpload", mappedBy="fileuplodtype", orphanRemoval=true)
     */
    private $fileuploadid;





    public function __construct()
    {
        $this->mediaUploadType = new ArrayCollection();
        $this->fileuploadid = new ArrayCollection();
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

    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    public function setMediaType(string $mediaType): self
    {
        $this->mediaType = $mediaType;

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

    public function getMediaUploadName(): ?UploadMedia
    {
        return $this->MediaUploadName;
    }

    public function setMediaUploadName(?UploadMedia $MediaUploadName): self
    {
        $this->MediaUploadName = $MediaUploadName;

        return $this;
    }

    public function getUploadMediaTypeUser(): ?User
    {
        return $this->uploadMediaTypeUser;
    }

    public function setUploadMediaTypeUser(?User $uploadMediaTypeUser): self
    {
        $this->uploadMediaTypeUser = $uploadMediaTypeUser;

        return $this;
    }

    public function getFileuploadid(): ?FileUpload
    {
        return $this->fileuploadid;
    }

    public function setFileuploadid(?FileUpload $fileuploadid): self
    {
        $this->fileuploadid = $fileuploadid;

        return $this;
    }

    public function addFileuploadid(FileUpload $fileuploadid): self
    {
        if (!$this->fileuploadid->contains($fileuploadid)) {
            $this->fileuploadid[] = $fileuploadid;
            $fileuploadid->setFileuplodtype($this);
        }

        return $this;
    }

    public function removeFileuploadid(FileUpload $fileuploadid): self
    {
        if ($this->fileuploadid->contains($fileuploadid)) {
            $this->fileuploadid->removeElement($fileuploadid);
            // set the owning side to null (unless already changed)
            if ($fileuploadid->getFileuplodtype() === $this) {
                $fileuploadid->setFileuplodtype(null);
            }
        }

        return $this;
    }



}
