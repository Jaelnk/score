<?php

namespace App\Entity;

use App\Repository\TdireccionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "Tdireccion")]
#[ORM\Entity(repositoryClass: TdireccionRepository::class)]
class Tdireccion
{
    #[ORM\Column(name: "ID_DIRECCION", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "TDIRECCION_ID_DIRECCION_seq", allocationSize: 1, initialValue: 1)]
    private $idDireccion;
    #[ORM\Column(name: "CALLE_PRINCIPAL", type: "string", length: 100, nullable: true)]
    private $callePrincipal;
    #[ORM\Column(name: "NUMERO_DOMICILIO", type: "string", length: 20, nullable: true)]
    private $numeroDomicilio;
    #[ORM\Column(name: "CALLE_SECUNDARIA", type: "string", length: 100, nullable: true)]
    private $calleSecundaria;
    #[ORM\Column(name: "REFERENCIA", type: "string", length: 200, nullable: true)]
    private $referencia;
    #[ORM\Column(name: "LATITUD", type: "decimal", precision: 19, scale: 6, nullable: true)]
    private $latitud;
    #[ORM\Column(name: "LONGITUD", type: "decimal", precision: 19, scale: 6, nullable: true)]
    private $longitud;
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
    #[ORM\ManyToOne(targetEntity: Tdpa::class)]
    #[ORM\JoinColumn(name: 'ID_CANTON', referencedColumnName: 'ID_DPA')]
    private $idCanton;
    #[ORM\ManyToOne(targetEntity: Tdpa::class)]
    #[ORM\JoinColumn(name: 'ID_ESTADO', referencedColumnName: 'ID_DPA')]
    private $idEstado;
    #[ORM\ManyToOne(targetEntity: Tdpa::class)]
    #[ORM\JoinColumn(name: 'ID_PAIS', referencedColumnName: 'ID_DPA')]
    private $idPais;
    #[ORM\ManyToOne(targetEntity: Tdpa::class)]
    #[ORM\JoinColumn(name: 'ID_PARROQUIA', referencedColumnName: 'ID_DPA')]
    private $idParroquia;
    #[ORM\ManyToOne(targetEntity: Tdpa::class)]
    #[ORM\JoinColumn(name: 'ID_PROVINCIA', referencedColumnName: 'ID_DPA')]
    private $idProvincia;
    #[ORM\ManyToOne(targetEntity: Tpersonainfo::class)]
    #[ORM\JoinColumn(name: 'ID_PERSONA', referencedColumnName: 'ID_PERSONA')]
    private $idPersona;

    public function getIdDireccion(): ?int
    {
        return $this->idDireccion;
    }

    public function getCallePrincipal(): ?string
    {
        return $this->callePrincipal;
    }

    public function setCallePrincipal(?string $callePrincipal): static
    {
        $this->callePrincipal = $callePrincipal;

        return $this;
    }

    public function getNumeroDomicilio(): ?string
    {
        return $this->numeroDomicilio;
    }

    public function setNumeroDomicilio(?string $numeroDomicilio): static
    {
        $this->numeroDomicilio = $numeroDomicilio;

        return $this;
    }

    public function getCalleSecundaria(): ?string
    {
        return $this->calleSecundaria;
    }

    public function setCalleSecundaria(?string $calleSecundaria): static
    {
        $this->calleSecundaria = $calleSecundaria;

        return $this;
    }

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(?string $referencia): static
    {
        $this->referencia = $referencia;

        return $this;
    }

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(?string $latitud): static
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(?string $longitud): static
    {
        $this->longitud = $longitud;

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

    public function getIdCanton(): ?Tdpa
    {
        return $this->idCanton;
    }

    public function setIdCanton(?Tdpa $idCanton): static
    {
        $this->idCanton = $idCanton;

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

    public function getIdPais(): ?Tdpa
    {
        return $this->idPais;
    }

    public function setIdPais(?Tdpa $idPais): static
    {
        $this->idPais = $idPais;

        return $this;
    }

    public function getIdParroquia(): ?Tdpa
    {
        return $this->idParroquia;
    }

    public function setIdParroquia(?Tdpa $idParroquia): static
    {
        $this->idParroquia = $idParroquia;

        return $this;
    }

    public function getIdProvincia(): ?Tdpa
    {
        return $this->idProvincia;
    }

    public function setIdProvincia(?Tdpa $idProvincia): static
    {
        $this->idProvincia = $idProvincia;

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


}
