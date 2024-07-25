<?php

namespace App\Entity;

use App\Repository\DireccionPersonaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DireccionPersonaRepository::class)]
class DireccionPersona
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PROVINCIA = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CANTON = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PARROQUIA = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CPRINCIPAL = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CSECUNDARIA = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NDOMICILIO = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $REFERENCIA = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LATITUD = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LONGITUD = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPROVINCIA(): ?string
    {
        return $this->PROVINCIA;
    }

    public function setPROVINCIA(?string $PROVINCIA): static
    {
        $this->PROVINCIA = $PROVINCIA;

        return $this;
    }

    public function getCANTON(): ?string
    {
        return $this->CANTON;
    }

    public function setCANTON(?string $CANTON): static
    {
        $this->CANTON = $CANTON;

        return $this;
    }

    public function getPARROQUIA(): ?string
    {
        return $this->PARROQUIA;
    }

    public function setPARROQUIA(?string $PARROQUIA): static
    {
        $this->PARROQUIA = $PARROQUIA;

        return $this;
    }

    public function getCPRINCIPAL(): ?string
    {
        return $this->CPRINCIPAL;
    }

    public function setCPRINCIPAL(?string $CPRINCIPAL): static
    {
        $this->CPRINCIPAL = $CPRINCIPAL;

        return $this;
    }

    public function getCSECUNDARIA(): ?string
    {
        return $this->CSECUNDARIA;
    }

    public function setCSECUNDARIA(?string $CSECUNDARIA): static
    {
        $this->CSECUNDARIA = $CSECUNDARIA;

        return $this;
    }

    public function getNDOMICILIO(): ?string
    {
        return $this->NDOMICILIO;
    }

    public function setNDOMICILIO(?string $NDOMICILIO): static
    {
        $this->NDOMICILIO = $NDOMICILIO;

        return $this;
    }

    public function getREFERENCIA(): ?string
    {
        return $this->REFERENCIA;
    }

    public function setREFERENCIA(?string $REFERENCIA): static
    {
        $this->REFERENCIA = $REFERENCIA;

        return $this;
    }

    public function getLATITUD(): ?string
    {
        return $this->LATITUD;
    }

    public function setLATITUD(?string $LATITUD): static
    {
        $this->LATITUD = $LATITUD;

        return $this;
    }

    public function getLONGITUD(): ?string
    {
        return $this->LONGITUD;
    }

    public function setLONGITUD(?string $LONGITUD): static
    {
        $this->LONGITUD = $LONGITUD;

        return $this;
    }
}
