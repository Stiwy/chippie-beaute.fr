<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $image_1;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_2;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_3;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_4;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $tva;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stock;

    #[ORM\ManyToOne(targetEntity: ProductSheet::class, inversedBy: 'products')]
    private $productSheet;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updateAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $keywork;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image_1;
    }

    public function setImage1(string $image_1): self
    {
        $this->image_1 = $image_1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image_2;
    }

    public function setImage2(?string $image_2): self
    {
        $this->image_2 = $image_2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image_3;
    }

    public function setImage3(?string $image_3): self
    {
        $this->image_3 = $image_3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image_4;
    }

    public function setImage4(?string $image_4): self
    {
        $this->image_4 = $image_4;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getProductSheet(): ?ProductSheet
    {
        return $this->productSheet;
    }

    public function setProductSheet(?ProductSheet $productSheet): self
    {
        $this->productSheet = $productSheet;

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
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getKeywork(): ?string
    {
        return $this->keywork;
    }

    public function setKeywork(?string $keywork): self
    {
        $this->keywork = $keywork;

        return $this;
    }
}
