<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserPostUploadRepository")
 */
class UserPostUpload
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="fk_user_userpostupload")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_user_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="fk_post_userpostupload")
     */
    private $fk_post_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FileUpload", inversedBy="fk_upload_userpostupload")
     */
    private $fk_upload_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkUserId(): ?User
    {
        return $this->fk_user_id;
    }

    public function setFkUserId(?User $fk_user_id): self
    {
        $this->fk_user_id = $fk_user_id;

        return $this;
    }

    public function getFkPostId(): ?Post
    {
        return $this->fk_post_id;
    }

    public function setFkPostId(?Post $fk_post_id): self
    {
        $this->fk_post_id = $fk_post_id;

        return $this;
    }

    public function getFkUploadId(): ?FileUpload
    {
        return $this->fk_upload_id;
    }

    public function setFkUploadId(?FileUpload $fk_upload_id): self
    {
        $this->fk_upload_id = $fk_upload_id;

        return $this;
    }
}
