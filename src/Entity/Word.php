<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 * @ApiResource
 */
class Word
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $spelling;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="words")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Traduction", inversedBy="words")
     */
    private $traductions;

    public function __construct()
    {
        $this->traductions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpelling(): ?string
    {
        return $this->spelling;
    }

    public function setSpelling(string $spelling): self
    {
        $this->spelling = $spelling;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Traduction[]
     */
    public function getTraductions(): Collection
    {
        return $this->traductions;
    }

    public function addTraduction(Traduction $traduction): self
    {
        if (!$this->traductions->contains($traduction)) {
            $this->traductions[] = $traduction;
            $traduction->addWord($this);
        }

        return $this;
    }

    public function removeTraduction(Traduction $traduction): self
    {
        if ($this->traductions->contains($traduction)) {
            $this->traductions->removeElement($traduction);
            $traduction->removeWord($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->spelling;
    }
}
