<?php

namespace App\Entity;

use App\Repository\TusuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: "tusuario")]
#[ORM\Entity(repositoryClass: TusuarioRepository::class)]
class Tusuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(name: "id_usuario", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "tusuario_id_usuario_seq", allocationSize: 1, initialValue: 1)]
    private $idUsuario;
    #[ORM\Column(name: "nombre_usuario", type: "string", length: 50, nullable: true)]
    private $nombreUsuario;
    #[ORM\Column(name: "roles", type: "json")]
    private $roles = [];
    #[ORM\Column(name: "password", type: "string", length: 255, nullable: true)]
    private $password;

    private $plainPassword;
    #[ORM\Column(name:"created_at", type:"datetime", nullable:false)]
    private $createdAt;
    #[ORM\Column(name:"created_by", type:"string", length:50, nullable:false)]
    private $createdBy;
    #[ORM\Column(name:"created_ip", type:"string", length:200, nullable:false)]
    private $createdIp;
    #[ORM\Column(name:"created_public_ip", type:"string", length:200, nullable:false)]
    private $createdPublicIp;
    #[ORM\Column(name:"created_browser", type:"string", length:250, nullable:false)]
    private $createdBrowser;
    #[ORM\Column(name:"updated_at", type:"datetime", nullable:true)]
    private $updatedAt;
    #[ORM\Column(name:"updated_by", type:"string", length:50, nullable:true)]
    private $updatedBy;
    #[ORM\Column(name:"updated_ip", type:"string", length:200, nullable:true)]
    private $updatedIp;
    #[ORM\Column(name:"updated_public_ip", type:"string", length:200, nullable:false)]
    private $updatedPublicIp;
    #[ORM\Column(name: "updated_browser", type: "string", length: 250, nullable: true)]
    private $updatedBrowser;
   /* #[ORM\ManyToOne(targetEntity: Tcatalogo::class)]
    #[ORM\JoinColumn(name: 'id_estado', referencedColumnName: 'id_catalogo')]*/
    private $idEstado;
    /*#[ORM\ManyToOne(targetEntity: Tpersona::class, inversedBy: "usuarios")]
    #[ORM\JoinColumn(name: 'id_persona', referencedColumnName: 'id_persona')]*/
    private $idPersona;

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function getNombreUsuario(): ?string
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario(?string $nombreUsuario): static
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedIp(): ?string
    {
        return $this->createdIp;
    }

    public function setCreatedIp(string $createdIp): static
    {
        $this->createdIp = $createdIp;

        return $this;
    }

    public function getCreatedPublicIp(): ?string
    {
        return $this->createdPublicIp;
    }

    public function setCreatedPublicIp(string $createdPublicIp): static
    {
        $this->createdPublicIp = $createdPublicIp;

        return $this;
    }

    public function getCreatedBrowser(): ?string
    {
        return $this->createdBrowser;
    }

    public function setCreatedBrowser(string $createdBrowser): static
    {
        $this->createdBrowser = $createdBrowser;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?string $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedIp(): ?string
    {
        return $this->updatedIp;
    }

    public function setUpdatedIp(?string $updatedIp): static
    {
        $this->updatedIp = $updatedIp;

        return $this;
    }

    public function getUpdatedPublicIp(): ?string
    {
        return $this->updatedPublicIp;
    }

    public function setUpdatedPublicIp(?string $updatedPublicIp): static
    {
        $this->updatedPublicIp = $updatedPublicIp;

        return $this;
    }

    public function getUpdatedBrowser(): ?string
    {
        return $this->updatedBrowser;
    }

    public function setUpdatedBrowser(?string $updatedBrowser): static
    {
        $this->updatedBrowser = $updatedBrowser;

        return $this;
    }

    public function getIdEstado(): ?Tcatalogo
    {
        return $this->idEstado;
    }

    public function setIdEstado(?Tcatalogo $idEstado): static
    {
        $this->idEstado = $idEstado;

        return $this;
    }

    public function getIdPersona(): ?Tpersonainfo
    {
        return $this->idPersona;
    }

    public function setIdPersona(?Tpersonainfo $idPersona): static
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->nombreUsuario ?? '';
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
        $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return (string)$this->nombreUsuario;
    }


    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }


    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }


}
