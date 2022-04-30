<?php


namespace App\Helper;


use Doctrine\ORM\Mapping as ORM;


trait Metable
{
    #[ORM\Column(type: 'string', length: 70, nullable: true)]
    protected ?string $metaTitle;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected ?string $metaDescription;

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }
}