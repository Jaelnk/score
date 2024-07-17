<?php

namespace App\Entity;

use App\Repository\TtelefonoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "Ttelefono")]
#[ORM\Entity(repositoryClass: TtelefonoRepository::class)]
class Ttelefono
{
    #[ORM\Column(name: "ID_TELEFONO", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "TTELEFONO_ID_TELEFONO_seq", allocationSize: 1, initialValue: 1)]
    private $idTelefono;
    #[ORM\Column(name: "NUMERO", type: "string", length: 10, nullable: true)]
    private $numero;
    #[ORM\Column(name: "EXTENSION", type: "string", length: 10, nullable: true)]
    private $extension;
    #[ORM\Column(name: "CREATED_AT", type: "datetime", nullable: false)]
    private $createdAt;
    #[ORM\Column(name: "CREATED_BY", type: "string", length: 50, nullable: false)]
    private $createdBy;
    #[ORM\Column(name: "CREATED_IP", type: "string", length: 200, nullable: false)]
    private $createdIp;
    #[ORM\Column(name: "CREATED_PUBLIC_IP", type: "string", length: 200, nullable: false)]
    private $createdPublicIp;
    #[ORM\Column(name: "CREATED_BROWSER", type: "string", length: 250, nullable: false)]
    private $createdBrowser;
    #[ORM\Column(name: "UPDATED_AT", type: "datetime", nullable: true)]
    private $updatedAt;
    #[ORM\Column(name: "UPDATED_BY", type: "string", length: 50, nullable: true)]
    private $updatedBy;
    #[ORM\Column(name: "UPDATED_IP", type: "string", length: 200, nullable: true)]
    private $updatedIp;
    #[ORM\Column(name: "UPDATED_PUBLIC_IP", type: "string", length: 200, nullable: true)]
    private $updatedPublicIp;
    #[ORM\Column(name: "UPDATED_BROWSER", type: "string", length: 250, nullable: true)]
    private $updatedBrowser;
    #[ORM\ManyToOne(targetEntity: Tcatalogo::class)]
    #[ORM\JoinColumn(name: 'ID_TIPO', referencedColumnName: 'ID_CATALOGO')]
    private $idTipo;
    #[ORM\ManyToOne(targetEntity: Tcatalogo::class)]
    #[ORM\JoinColumn(name: 'ID_ESTADO', referencedColumnName: 'ID_CATALOGO')]
    private $idEstado;
    #[ORM\ManyToOne(targetEntity: Tpersonainfo::class)]
    #[ORM\JoinColumn(name: 'ID_PERSONA', referencedColumnName: 'ID_PERSONA')]
    private $idPersona;

    public function getIdTelefono(): ?int
    {
        return $this->idTelefono;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(?string $extension): static
    {
        $this->extension = $extension;

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

    public function getIdTipo(): ?Tcatalogo
    {
        return $this->idTipo;
    }

    public function setIdTipo(?Tcatalogo $idTipo): static
    {
        $this->idTipo = $idTipo;

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

    public function getIdEstado(): ?Tcatalogo
    {
        return $this->idEstado;
    }

    public function setIdEstado(?Tcatalogo $idEstado): static
    {
        $this->idEstado = $idEstado;

        return $this;
    }


}
