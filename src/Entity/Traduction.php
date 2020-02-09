<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TraductionRepository")
 */
class Traduction
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\word", inversedBy="traductions")
     */
    private $words;

    public function __construct()
    {
        $this->words = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|word[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    public function addWord(word $word): self
    {
        if (!$this->words->contains($word)) {
            $this->words[] = $word;
        }

        return $this;
    }

    public function removeWord(word $word): self
    {
        if ($this->words->contains($word)) {
            $this->words->removeElement($word);
        }

        return $this;
    }
}
