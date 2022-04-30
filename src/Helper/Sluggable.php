<?php


namespace App\Helper;


use Doctrine\ORM\Mapping as ORM;


trait Sluggable
{
    #[ORM\Column(type: 'string', length: 255)]
    protected ?string $slug;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}