<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $label;

    #[ORM\Column(type: 'string', length: 255)]
    private $position;

    #[ORM\Column(type: 'boolean')]
    private $bolder;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $UpdateAt;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'subCategories')]
    private $categorie;

    #[ORM\Column(type: 'integer')]
    private $positionColumn;

    #[ORM\OneToMany(mappedBy: 'subCategory', targetEntity: ProductSheet::class)]
    private $productSheets;

    public function __construct()
    {
        $this->productSheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getBolder(): ?bool
    {
        return $this->bolder;
    }

    public function setBolder(bool $bolder): self
    {
        $this->bolder = $bolder;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->UpdateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $UpdateAt): self
    {
        $this->UpdateAt = $UpdateAt;

        return $this;
    }

    public function getCategorie(): ?Category
    {
        return $this->categorie;
    }

    public function setCategorie(?Category $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPositionColumn(): ?int
    {
        return $this->positionColumn;
    }

    public function setPositionColumn(int $positionColumn): self
    {
        $this->positionColumn = $positionColumn;

        return $this;
    }

    /**
     * @return Collection<int, ProductSheet>
     */
    public function getProductSheets(): Collection
    {
        return $this->productSheets;
    }

    public function addProductSheet(ProductSheet $productSheet): self
    {
        if (!$this->productSheets->contains($productSheet)) {
            $this->productSheets[] = $productSheet;
            $productSheet->setSubCategory($this);
        }

        return $this;
    }

    public function removeProductSheet(ProductSheet $productSheet): self
    {
        if ($this->productSheets->removeElement($productSheet)) {
            // set the owning side to null (unless already changed)
            if ($productSheet->getSubCategory() === $this) {
                $productSheet->setSubCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getLabel();
    }
}
