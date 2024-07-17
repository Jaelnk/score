<?php

namespace App\Entity;

use App\Repository\TcatalogoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:"tcatalogo")]
#[ORM\Entity(repositoryClass: TcatalogoRepository::class)]
class Tcatalogo
{
    #[ORM\Column( name:"ID_CATALOGO", type:"integer", nullable:false)]
    #[ORM\Id ]
    #[ORM\GeneratedValue(strategy:"SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName:"TCATALOGO_ID_CATALOGO_seq", allocationSize:1, initialValue:1)]
    private $idCatalogo;
    #[ORM\Column(name:"VALOR_NUM", type:"decimal", precision:19, scale:6, nullable:true)]
    private $valorNum;
    #[ORM\Column(name:"VALOR_DATE", type:"date", nullable:true)]
    private $valorDate;
    #[ORM\Column(name:"VALOR_TIME", type:"datetime", nullable:true)]
    private $valorTime;
    #[ORM\Column(name:"VALOR_TEXT", type:"string", length:1000, nullable:true)]
    private $valorText;
    #[ORM\Column(name:"CODIGO_MODELO_EXPERTO", type:"string", length:100, nullable:true)]
    private $codigoModeloExperto;
    #[ORM\Column(name:"DESC_OBSERVACIONES", type:"string", length:1000, nullable:true)]
    private $descObservaciones;
    #[ORM\Column(name:"CREATED_AT", type:"datetime", nullable:false)]
    private $createdAt;
    #[ORM\Column(name:"CREATED_BY", type:"string", length:50, nullable:false)]
    private $createdBy;
    #[ORM\Column(name:"CREATED_IP", type:"string", length:200, nullable:false)]
    private $createdIp;
    #[ORM\Column(name:"CREATED_PUBLIC_IP", type:"string", length:200, nullable:false)]
    private $createdPublicIp;
    #[ORM\Column(name:"CREATED_BROWSER", type:"string", length:250, nullable:false)]
    private $createdBrowser;
    #[ORM\Column(name:"UPDATED_AT", type:"datetime", nullable:true)]
    private $updatedAt;
    #[ORM\Column(name:"UPDATED_BY", type:"string", length:50, nullable:true)]
    private $updatedBy;
    #[ORM\Column(name:"UPDATED_IP", type:"string", length:200, nullable:true)]
    private $updatedIp;
    #[ORM\Column(name:"UPDATED_PUBLIC_IP", type:"string", length:200, nullable:false)]
    private $updatedPublicIp;
    #[ORM\Column(name:"UPDATED_BROWSER", type:"string", length:250, nullable:true)]
    private $updatedBrowser;
    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'ID_ESTADO', referencedColumnName: 'ID_CATALOGO')]
    private $idEstado;
    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'ID_CATALOGO_PADRE', referencedColumnName: 'ID_CATALOGO')]
    private $idCatalogoPadre;

    public function getIdCatalogo(): ?int
    {
        return $this->idCatalogo;
    }

    public function getValorNum(): ?string
    {
        return $this->valorNum;
    }

    public function setValorNum(?string $valorNum): static
    {
        $this->valorNum = $valorNum;

        return $this;
    }

    public function getValorDate(): ?\DateTimeInterface
    {
        return $this->valorDate;
    }

    public function setValorDate(?\DateTimeInterface $valorDate): static
    {
        $this->valorDate = $valorDate;

        return $this;
    }

    public function getValorTime(): ?\DateTimeInterface
    {
        return $this->valorTime;
    }

    public function setValorTime(?\DateTimeInterface $valorTime): static
    {
        $this->valorTime = $valorTime;

        return $this;
    }

    public function getValorText(): ?string
    {
        return $this->valorText;
    }

    public function setValorText(?string $valorText): static
    {
        $this->valorText = $valorText;

        return $this;
    }

    public function getCodigoModeloExperto(): ?string
    {
        return $this->codigoModeloExperto;
    }

    public function setCodigoModeloExperto(?string $codigoModeloExperto): static
    {
        $this->codigoModeloExperto = $codigoModeloExperto;

        return $this;
    }

    public function getDescObservaciones(): ?string
    {
        return $this->descObservaciones;
    }

    public function setDescObservaciones(?string $descObservaciones): static
    {
        $this->descObservaciones = $descObservaciones;

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

    public function getIdEstado(): ?self
    {
        return $this->idEstado;
    }

    public function setIdEstado(?self $idEstado): static
    {
        $this->idEstado = $idEstado;

        return $this;
    }

    public function getIdCatalogoPadre(): ?self
    {
        return $this->idCatalogoPadre;
    }

    public function setIdCatalogoPadre(?self $idCatalogoPadre): static
    {
        $this->idCatalogoPadre = $idCatalogoPadre;

        return $this;
    }

    public function __toString()
    {
        return $this->idCatalogo;
    }

}
