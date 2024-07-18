<?php

namespace App\Entity;


use App\Repository\TdpaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "tdpa")]
#[ORM\Entity(repositoryClass: TdpaRepository::class)]
class Tdpa
{
    #[ORM\Column(name: "ID_DPA", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "TDPA_ID_DPA_seq", allocationSize: 1, initialValue: 1)]
    private $idDpa;
    #[ORM\Column(name: "CODIGO_DPA", type: "string", length: 20, nullable: true)]
    private $codigoDpa;
    #[ORM\Column(name: "NOMBRE", type: "string", length: 200, nullable: true)]
    private $nombre;
    #[ORM\Column(name: "NACIONALIDAD", type: "string", length: 200, nullable: true)]
    private $nacionalidad;
    #[ORM\Column(name: "CODIGO_AREA", type: "integer", nullable: true)]
    private $codigoArea;
    #[ORM\Column(name: "CODIGO_EXTERNO", type: "string", length: 50, nullable: true)]
    private $codigoExterno;
    #[ORM\Column(name: "SIGLAS", type: "string", length: 5, nullable: true)]
    private $siglas;
    #[ORM\Column(name: "created_at", type: "oracle_datetime", nullable: false)]
    private $createdAt;
    #[ORM\Column(name: "created_by", type: "string", length: 50, nullable: false)]
    private $createdBy;
    #[ORM\Column(name: "created_ip", type: "string", length: 200, nullable: false)]
    private $createdIp;
    #[ORM\Column(name: "created_public_ip", type: "string", length: 200, nullable: false)]
    private $createdPublicIp;
    #[ORM\Column(name: "created_browser", type: "string", length: 250, nullable: false)]
    private $createdBrowser;
    #[ORM\Column(name: "updated_at", type: "oracle_datetime", nullable: true)]
    private $updatedAt;
    #[ORM\Column(name: "updated_by", type: "string", length: 50, nullable: true)]
    private $updatedBy;
    #[ORM\Column(name: "updated_ip", type: "string", length: 200, nullable: true)]
    private $updatedIp;
    #[ORM\Column(name: "updated_public_ip", type: "string", length: 200, nullable: false)]
    private $updatedPublicIp;
    #[ORM\Column(name: "updated_browser", type: "string", length: 250, nullable: true)]
    private $updatedBrowser;
    #[ORM\ManyToOne(targetEntity: Tdpa::class)]
    #[ORM\JoinColumn(name: 'ID_DPA_PADRE', referencedColumnName: 'ID_DPA')]
    private $idDpaPadre;
    #[ORM\ManyToOne(targetEntity: Tcatalogo::class)]
    #[ORM\JoinColumn(name: 'ID_ESTADO', referencedColumnName: 'ID_CATALOGO')]
    private $idEstado;
    #[ORM\ManyToOne(targetEntity: Tcatalogo::class)]
    #[ORM\JoinColumn(name: 'ID_TIPO', referencedColumnName: 'ID_CATALOGO')]
    private $idTipo;
    #[ORM\OneToMany(targetEntity: Tdireccion::class, mappedBy: 'idPersona', orphanRemoval: true, fetch: 'EXTRA_LAZY', cascade: ['persist', 'remove'])]
    private $direccion;

    public function __construct()
    {
        $this->direccion = new ArrayCollection();
    }
    public function getIdDpa(): ?int
    {
        return $this->idDpa;
    }

    public function getCodigoDpa(): ?string
    {
        return $this->codigoDpa;
    }

    public function setCodigoDpa(?string $codigoDpa): static
    {
        $this->codigoDpa = $codigoDpa;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNacionalidad(): ?string
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?string $nacionalidad): static
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getCodigoArea(): ?int
    {
        return $this->codigoArea;
    }

    public function setCodigoArea(?int $codigoArea): static
    {
        $this->codigoArea = $codigoArea;

        return $this;
    }

    public function getCodigoExterno(): ?string
    {
        return $this->codigoExterno;
    }

    public function setCodigoExterno(?string $codigoExterno): static
    {
        $this->codigoExterno = $codigoExterno;

        return $this;
    }

    public function getSiglas(): ?string
    {
        return $this->siglas;
    }

    public function setSiglas(?string $siglas): static
    {
        $this->siglas = $siglas;

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

    public function getIdDpaPadre(): ?self
    {
        return $this->idDpaPadre;
    }

    public function setIdDpaPadre(?self $idDpaPadre): static
    {
        $this->idDpaPadre = $idDpaPadre;

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

    public function getIdTipo(): ?Tcatalogo
    {
        return $this->idTipo;
    }

    public function setIdTipo(?Tcatalogo $idTipo): static
    {
        $this->idTipo = $idTipo;

        return $this;
    }


    public function getDireccion(): Collection
    {
        return $this->direccion;
    }

    public function addDireccion(Tdireccion $tdireccion)
    {
        if ($this->direccion->contains($tdireccion)) {
            return;
        }
        $this->direccion[] = $tdireccion;
        $tdireccion->setIdPersona($this);
    }

    public function removeDireccion(Tdireccion $tdireccion)
    {
        if (!$this->direccion->contains($tdireccion)) {
            return;
        }
        $this->direccion->removeElement($tdireccion);
        $tdireccion->setIdPersona(null);
    }


}
