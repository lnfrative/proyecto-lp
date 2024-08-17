<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface; 

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'usuarios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UsuarioRol $rol = null;

    /**
     * @var Collection<int, Reserva>
     */
    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'usuario')]
    private Collection $reservas;

    public function __construct()
    {
        $this->reservas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRol(): ?UsuarioRol
    {
        return $this->rol;
    }

    public function setRol(?UsuarioRol $rol): static
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): static
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas->add($reserva);
            $reserva->setUsuario($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): static
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getUsuario() === $this) {
                $reserva->setUsuario(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        // Aquí debes retornar los roles del usuario. 
        // Puedes obtenerlos de la entidad UsuarioRol o de alguna otra lógica que tengas.
        // Por ejemplo, si UsuarioRol tiene una propiedad 'nombre' que almacena el rol:
        return [$this->rol->getRol()]; 
    }

    // Ya tienes el método getPassword(), así que no necesitas cambiarlo.

    public function getSalt(): ?string
    {
        return null; // Si usas bcrypt o Argon2i, puedes retornar null aquí
    }

    public function eraseCredentials(): void
    {
        // Si no almacenas credenciales sensibles temporalmente, puedes dejar este método vacío
    }

    public function getUserIdentifier(): string
    {
        // Retorna un identificador único. Puedes usar el email si es único
        return $this->email; 
    }
}
