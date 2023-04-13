<?php

namespace App\Entity;
use App\Repository\ReclamationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:ReclamationsRepository::class)]
class Reclamations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 65535)]
    #[Assert\NotBlank(message: 'Subject cannot be empty')]
    private ?string $subject=null;

    #[ORM\Column(length: 65535)]
    private ?String $message=null;

    #[ORM\Column(length: 65535)]
    private ?string $status =null;
    
    #[ORM\Column(name: "created_at", type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private \DateTime $createdAt;

    #[ORM\Column(length: 100)]
    private ?string $email;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id_user")]
    private ?User $user_id;

    
   

   //#[ORM\OneToOne(mappedBy:''/*targetEntity: \App\Entity\User::class*/)]
   #//[ORM\JoinColumn(name: "user_id", referencedColumnName: "id_user")]
   //#[ORM\Id]
  // #[ORM\GeneratedValue(strategy: "NONE")]
 
 
 
 //#[ORM\OneToOne(mappedBy:'users')]
 // #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id_user")]
   //private ?User $user=null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
    // public function getUserFullName(): ?string
    // {
    //     return $this->user_id ? $this->user_id->getFullName() : null;
    // }

}
