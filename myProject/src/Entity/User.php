<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $surname;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $phonenumber;

    /**
     * @ORM\Column(type="json")
     */
    private $accountstatus = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserPostUpload", mappedBy="fk_user_id", orphanRemoval=true)
     */
    private $fk_user_userpostupload;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserTypeMaster", inversedBy="fk_userType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_userType;

    public function __construct()
    {
        $this->postuser = new ArrayCollection();
        $this->fk_user_userpostupload = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        if (empty($roles)) {
            $roles[] = ['ROLE_USER', 'ROLE_ADMIN'];
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {

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

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(?string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostuser(): Collection
    {
        return $this->postuser;
    }

    public function addPostuser(Post $postuser): self
    {
        if (!$this->postuser->contains($postuser)) {
            $this->postuser[] = $postuser;
            $postuser->setPostuser($this);
        }

        return $this;
    }

    public function removePostuser(Post $postuser): self
    {
        if ($this->postuser->contains($postuser)) {
            $this->postuser->removeElement($postuser);
            // set the owning side to null (unless already changed)
            if ($postuser->getPostuser() === $this) {
                $postuser->setPostuser(null);
            }
        }

        return $this;
    }

    public function getAccountstatus(): ?array
    {
        $accountstatus = $this->accountstatus;
        if (empty($accountstatus)) {
            $accountstatus[] = ['ACTIVE', 'IN_ACTIVE', 'DELETED'];
        }

        return array_unique($accountstatus);
    }

    public function setAccountstatus(array $accountstatus): self
    {
        $this->accountstatus = $accountstatus;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|UserPostUpload[]
     */
    public function getFkUserUserpostupload(): Collection
    {
        return $this->fk_user_userpostupload;
    }

    public function addFkUserUserpostupload(UserPostUpload $fkUserUserpostupload): self
    {
        if (!$this->fk_user_userpostupload->contains($fkUserUserpostupload)) {
            $this->fk_user_userpostupload[] = $fkUserUserpostupload;
            $fkUserUserpostupload->setFkUserId($this);
        }

        return $this;
    }

    public function removeFkUserUserpostupload(UserPostUpload $fkUserUserpostupload): self
    {
        if ($this->fk_user_userpostupload->contains($fkUserUserpostupload)) {
            $this->fk_user_userpostupload->removeElement($fkUserUserpostupload);
            // set the owning side to null (unless already changed)
            if ($fkUserUserpostupload->getFkUserId() === $this) {
                $fkUserUserpostupload->setFkUserId(null);
            }
        }

        return $this;
    }

    public function getFkUserType(): ?UserTypeMaster
    {
        return $this->fk_userType;
    }

    public function setFkUserType(?UserTypeMaster $fk_userType): self
    {
        $this->fk_userType = $fk_userType;

        return $this;
    }

}
