<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FileUploadRepository")
 */
class FileUpload
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploaded_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fileName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", mappedBy="postfile")
     */
    private $filepost;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etag;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageUrl;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="userMediaData")
     */
    private $MediaUserData;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UploadMediaType", inversedBy="fileuploadid")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fileuplodtype;





    public function __construct()
    {
        $this->filepost = new ArrayCollection();
        $this->MediaUserData = new ArrayCollection();
        $this->fileuplodtype = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(?\DateTimeInterface $uploaded_at): self
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->fileName;
    }

    public function setFilename(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getFilepost(): Collection
    {
        return $this->filepost;
    }

    public function addFilepost(Post $filepost): self
    {
        if (!$this->filepost->contains($filepost)) {
            $this->filepost[] = $filepost;
            $filepost->addPostfile($this);
        }

        return $this;
    }

    public function removeFilepost(Post $filepost): self
    {
        if ($this->filepost->contains($filepost)) {
            $this->filepost->removeElement($filepost);
            $filepost->removePostfile($this);
        }

        return $this;
    }

    public function getEtag(): ?string
    {
        return $this->etag;
    }

    public function setEtag(string $etag): self
    {
        $this->etag = $etag;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getMediaUserData(): Collection
    {
        return $this->MediaUserData;
    }

    public function addMediaUserData(User $mediaUserData): self
    {
        if (!$this->MediaUserData->contains($mediaUserData)) {
            $this->MediaUserData[] = $mediaUserData;
            $mediaUserData->addUserMediaData($this);
        }

        return $this;
    }

    public function removeMediaUserData(User $mediaUserData): self
    {
        if ($this->MediaUserData->contains($mediaUserData)) {
            $this->MediaUserData->removeElement($mediaUserData);
            $mediaUserData->removeUserMediaData($this);
        }

        return $this;
    }

    /**
     * @return Collection|UploadMediaType[]
     */
    public function getFileuplodtype(): Collection
    {
        return $this->fileuplodtype;
    }

    public function addFileuplodtype(UploadMediaType $fileuplodtype): self
    {
        if (!$this->fileuplodtype->contains($fileuplodtype)) {
            $this->fileuplodtype[] = $fileuplodtype;
            $fileuplodtype->setFileuploadid($this);
        }

        return $this;
    }

    public function removeFileuplodtype(UploadMediaType $fileuplodtype): self
    {
        if ($this->fileuplodtype->contains($fileuplodtype)) {
            $this->fileuplodtype->removeElement($fileuplodtype);
            // set the owning side to null (unless already changed)
            if ($fileuplodtype->getFileuploadid() === $this) {
                $fileuplodtype->setFileuploadid(null);
            }
        }

        return $this;
    }

    public function setFileuplodtype(?UploadMediaType $fileuplodtype): self
    {
        $this->fileuplodtype = $fileuplodtype;

        return $this;
    }

 
}
