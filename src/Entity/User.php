<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $agreedtermsAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $forgotPassIdentity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="createdBy")
     */
    private $trick;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="updatedBy")
     */
    private $updatedTrick;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="author")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Picture", inversedBy="author")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Video", inversedBy="author")
     */
    private $video;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getAgreedtermsAt(): ?\DateTimeInterface
    {
        return $this->agreedtermsAt;
    }

    public function setAgreedtermsAt(?\DateTimeInterface $agreedtermsAt): self
    {
        $this->agreedtermsAt = $agreedtermsAt;

        return $this;
    }

    public function getForgotPassIdentity(): ?string
    {
        return $this->forgotPassIdentity;
    }

    public function setForgotPassIdentity(string $forgotPassIdentity): self
    {
        $this->forgotPassIdentity = $forgotPassIdentity;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    public function getUpdatedTrick(): ?Trick
    {
        return $this->updatedTrick;
    }

    public function setUpdatedTrick(?Trick $updatedTrick): self
    {
        $this->updatedTrick = $updatedTrick;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

        return $this;
    }
}
