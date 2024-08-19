<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
#[UniqueEntity(
    fields: ['usuario', 'horario', 'created_at'],
    message: 'Horario ya reservado por el usuario.',
    errorPath: 'hora',
)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ReservaEstado $estado = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cubiculo $cubiculo = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Horario $horario = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstado(): ?ReservaEstado
    {
        return $this->estado;
    }

    public function setEstado(?ReservaEstado $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCubiculo(): ?Cubiculo
    {
        return $this->cubiculo;
    }

    public function setCubiculo(?Cubiculo $cubiculo): static
    {
        $this->cubiculo = $cubiculo;

        return $this;
    }

    public function getHorario(): ?Horario
    {
        return $this->horario;
    }

    public function setHorario(?Horario $horario): static
    {
        $this->horario = $horario;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
