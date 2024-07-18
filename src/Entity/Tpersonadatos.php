<?php

namespace App\Entity;

use App\Repository\TpersonadatosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TpersonadatosRepository::class)]
class Tpersonadatos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $IDENTIFICACION = null;

    #[ORM\Column(length: 255)]
    private ?string $NOMBRES = null;

    #[ORM\Column(length: 255)]
    private ?string $APELLIDOS = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CORREO_PERSONAL = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDENTIFICACION(): ?string
    {
        return $this->IDENTIFICACION;
    }

    public function setIDENTIFICACION(string $IDENTIFICACION): static
    {
        $this->IDENTIFICACION = $IDENTIFICACION;

        return $this;
    }

    public function getNOMBRES(): ?string
    {
        return $this->NOMBRES;
    }

    public function setNOMBRES(string $NOMBRES): static
    {
        $this->NOMBRES = $NOMBRES;

        return $this;
    }

    public function getAPELLIDOS(): ?string
    {
        return $this->APELLIDOS;
    }

    public function setAPELLIDOS(string $APELLIDOS): static
    {
        $this->APELLIDOS = $APELLIDOS;

        return $this;
    }

    public function getCORREOPERSONAL(): ?string
    {
        return $this->CORREO_PERSONAL;
    }

    public function setCORREOPERSONAL(?string $CORREO_PERSONAL): static
    {
        $this->CORREO_PERSONAL = $CORREO_PERSONAL;

        return $this;
    }
}
