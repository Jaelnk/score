<?php

namespace App\Entity;

use App\Repository\TpersonaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "tpersonainfo")]
#[ORM\Entity(repositoryClass: TpersonaRepository::class)]
class Tpersonainfo
{

    #[ORM\Id]
    #[ORM\Column(name: "ID_PERSONA", type: "integer", nullable: false)]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "TPERSONA_ID_PERSONA_SEQ", allocationSize: 1, initialValue: 1)]
    private $idPersona;
    #[ORM\Column(name: "NOMBRES", type: "string", length: 150, nullable: true)]
    private $nombres;
    #[ORM\Column(name: "APELLIDOS", type: "string", length: 150, nullable: true)]
    private $apellidos;
    #[ORM\Column(name: "IDENTIFICACION", type: "string", length: 13, nullable: true)]
    private $identificacion;
    #[ORM\Column(name: "SEXO", type: "string", length: 1, nullable: true)]
    private $sexo;
    #[ORM\Column(name: "FREGISTRO", type: "date", nullable: true)]
    private $fregistro;
    #[ORM\Column(name: "CORREO_TRABAJO", type: "string", length: 200, nullable: true)]
    private $correoTrabajo;
    #[ORM\Column(name: "CORREO_PERSONAL", type: "string", length: 200, nullable: true)]
    private $correoPersonal;
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
    #[ORM\JoinColumn(name: "ID_ESTADO", referencedColumnName: "ID_CATALOGO")]
    private $idEstado;
    #[ORM\ManyToOne(targetEntity: Tcatalogo::class)]
    #[ORM\JoinColumn(name: "ID_TIPO_IDENTIFICACION", referencedColumnName: "ID_CATALOGO")]
    private $idTipoIdentificacion;

    #[ORM\OneToMany(targetEntity: Tusuario::class, mappedBy: "idPersona", cascade: ["persist", "remove"], fetch: "EXTRA_LAZY", orphanRemoval: true)]
    private $usuarios;

    #[ORM\OneToMany(targetEntity: Tdireccion::class, mappedBy: "idPersona", cascade: ["persist", "remove"], fetch: "EXTRA_LAZY", orphanRemoval: true)]
    private Collection $direccion;

    #[ORM\OneToMany(targetEntity: Ttelefono::class, mappedBy: "idPersona", cascade: ["persist", "remove"], fetch: "EXTRA_LAZY", orphanRemoval: true)]
    private Collection $telefono;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->direccion = new ArrayCollection();
        $this->telefono = new ArrayCollection();
    }

    public function getIdPersona(): ?int
    {
        return $this->idPersona;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(?string $nombres): static
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): static
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getIdentificacion(): ?string
    {
        return $this->identificacion;
    }

    public function setIdentificacion(?string $identificacion): static
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->sexo;
    }

    public function setSexo(?string $sexo): static
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getFregistro(): ?\DateTimeInterface
    {
        return $this->fregistro;
    }

    public function setFregistro(?\DateTimeInterface $fregistro): static
    {
        $this->fregistro = $fregistro;

        return $this;
    }

    public function getCorreoTrabajo(): ?string
    {
        return $this->correoTrabajo;
    }

    public function setCorreoTrabajo(?string $correoTrabajo): static
    {
        $this->correoTrabajo = $correoTrabajo;

        return $this;
    }

    public function getCorreoPersonal(): ?string
    {
        return $this->correoPersonal;
    }

    public function setCorreoPersonal(?string $correoPersonal): static
    {
        $this->correoPersonal = $correoPersonal;

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

    public function getIdTipoIdentificacion(): ?Tcatalogo
    {
        return $this->idTipoIdentificacion;
    }

    public function setIdTipoIdentificacion(?Tcatalogo $idTipoIdentificacion): static
    {
        $this->idTipoIdentificacion = $idTipoIdentificacion;

        return $this;
    }


    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Tusuario $tusuarios)
    {
        if ($this->usuarios->contains($tusuarios)) {
            return;
        }
        $this->usuarios[] = $tusuarios;
        $tusuarios->setIdPersona($this);
    }

    public function removeUsuario(Tusuario $tusuarios)
    {
        if (!$this->usuarios->contains($tusuarios)) {
            return;
        }
        $this->usuarios->removeElement($tusuarios);
        $tusuarios->setIdPersona(null);
    }

    /**
     * @return Collection|Tdireccion[]
     */
    public function getDireccion(): Collection
    {
        return $this->direccion;
    }

    public function addDireccion(Tdireccion $direccion): self
    {
        if (!$this->direccion->contains($direccion)) {
            $this->direccion[] = $direccion;
            $direccion->setIdPersona($this);
        }
        return $this;
    }

    public function removeDireccion(Tdireccion $direccion): self
    {
        if ($this->direccion->removeElement($direccion)) {
            // set the owning side to null (unless already changed)
            if ($direccion->getIdPersona() === $this) {
                $direccion->setIdPersona(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Ttelefono[]
     */
    public function getTelefono(): Collection
    {
        return $this->telefono;
    }

    public function addTelefono(Ttelefono $ttelefono): self
    {
        if (!$this->telefono->contains($ttelefono)) {
            $this->telefono[] = $ttelefono;
            $ttelefono->setIdPersona($this);
        }
        return $this;
    }

    public function removeTelefono(Ttelefono $ttelefono): self
    {
        if ($this->telefono->removeElement($ttelefono)) {
            // set the owning side to null (unless already changed)
            if ($ttelefono->getIdPersona() === $this) {
                $ttelefono->setIdPersona(null);
            }
        }
        return $this;
    }


}
