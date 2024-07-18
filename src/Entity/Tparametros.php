<?php

namespace App\Entity;

use App\Repository\TparametrosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "TPARAMETROS")]
#[ORM\Entity(repositoryClass: TparametrosRepository::class)]
class Tparametros
{
    #[ORM\Column(name: "ID_PARAMETRO", type: "string", length: 50, nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "TPARAMETROS_ID_PARAMETRO_seq", allocationSize: 1, initialValue: 1)]
    private $idParametro;
    #[ORM\Column(name: "VALOR_NUM", type: "integer", nullable: false)]
    private $valorNum;
    #[ORM\Column(name: "VALOR_DATE", type: "date", nullable: true)]
    private $valorDate;
    #[ORM\Column(name: "VALOR_TIME", type: "datetime", nullable: true)]
    private $valorTime;
    #[ORM\Column(name: "VALOR_TEXT", type: "string", length: 1000, nullable: true)]
    private $valorText;
    #[ORM\Column(name: "DESC_DESCRIPCION", type: "string", length: 1000, nullable: true)]
    private $descDescripcion;
    #[ORM\Column(name: "CARGAR_MEMORIA", type: "integer", nullable: true)]
    private $cargarMemoria;
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
    #[ORM\JoinColumn(name: 'ID_MODULO', referencedColumnName: 'ID_CATALOGO')]
    private $idModulo;

    public function getIdParametro(): ?string
    {
        return $this->idParametro;
    }

    public function getValorNum(): ?int
    {
        return $this->valorNum;
    }

    public function setValorNum(int $valorNum): static
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

    public function getDescDescripcion(): ?string
    {
        return $this->descDescripcion;
    }

    public function setDescDescripcion(?string $descDescripcion): static
    {
        $this->descDescripcion = $descDescripcion;

        return $this;
    }

    public function getCargarMemoria(): ?int
    {
        return $this->cargarMemoria;
    }

    public function setCargarMemoria(?int $cargarMemoria): static
    {
        $this->cargarMemoria = $cargarMemoria;

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

    public function getIdModulo(): ?Tcatalogo
    {
        return $this->idModulo;
    }

    public function setIdModulo(?Tcatalogo $idModulo): static
    {
        $this->idModulo = $idModulo;

        return $this;
    }


}
