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
     * @ORM\Column(type="string", length=255)
     */
    private $etag;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageUrl;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UploadMediaType", inversedBy="fileuploadid")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fileuplodtype;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserPostUpload", mappedBy="fk_upload_id")
     */
    private $fk_upload_userpostupload;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thumbnail_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Objectkey;

    public function __construct()
    {
        $this->filepost = new ArrayCollection();
        $this->fileuplodtype = new ArrayCollection();
        $this->fk_upload_userpostupload = new ArrayCollection();
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

    /**
     * @return Collection|UserPostUpload[]
     */
    public function getFkUploadUserpostupload(): Collection
    {
        return $this->fk_upload_userpostupload;
    }

    public function addFkUploadUserpostupload(UserPostUpload $fkUploadUserpostupload): self
    {
        if (!$this->fk_upload_userpostupload->contains($fkUploadUserpostupload)) {
            $this->fk_upload_userpostupload[] = $fkUploadUserpostupload;
            $fkUploadUserpostupload->setFkUploadId($this);
        }

        return $this;
    }

    public function removeFkUploadUserpostupload(UserPostUpload $fkUploadUserpostupload): self
    {
        if ($this->fk_upload_userpostupload->contains($fkUploadUserpostupload)) {
            $this->fk_upload_userpostupload->removeElement($fkUploadUserpostupload);
            // set the owning side to null (unless already changed)
            if ($fkUploadUserpostupload->getFkUploadId() === $this) {
                $fkUploadUserpostupload->setFkUploadId(null);
            }
        }

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

    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnail_url;
    }

    public function setThumbnailUrl(?string $thumbnail_url): self
    {
        $this->thumbnail_url = $thumbnail_url;

        return $this;
    }

    public function getObjectkey(): ?string
    {
        return $this->Objectkey;
    }

    public function setObjectkey(?string $Objectkey): self
    {
        $this->Objectkey = $Objectkey;

        return $this;
    }

 
}
