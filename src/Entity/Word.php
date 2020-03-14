<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WordRepository")
 * @ApiResource(normalizationContext = {"groups":{"words_read"}})
 */
class Word
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"words_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"words_read"})
     * @Assert\NotBlank(message="L'orthographe du mot est obligatoire")
     * @Assert\Length(max=50, maxMessage="Ce mot est trop long. Le maximum de caractères autoristé est {{ limit }}.")
     * @Assert\Type(type="string", message="Ahahahah strinnnnnng")
     */
    private $spelling;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="words", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"words_read"})
     * @Assert\NotBlank(message="Le type est obligatoire")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Traduction", inversedBy="words")
     * @Groups({"words_read"})
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

    /**
     * Récupère le nombre de traductions disponibles
     * juste pour tester l'exposition d'un paramètre calculé via api_platform
     * @Groups({"words_read"})
     *
     * @return void
     */
    public function getTraductionsCount(): float
    {
        return $this->getTraductions()->count();
    }

    public function __toString()
    {
        return $this->spelling;
    }
}
