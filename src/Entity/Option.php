<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\ManyToMany(targetEntity: Vehicle::class, inversedBy: 'options')]
    private Collection $vehicle;

    public function __construct()
    {
        $this->vehicle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicle(): Collection
    {
        return $this->vehicle;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicle->contains($vehicle)) {
            $this->vehicle->add($vehicle);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        $this->vehicle->removeElement($vehicle);

        return $this;
    }
}
