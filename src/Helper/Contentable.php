<?php


namespace App\Helper;


use Doctrine\ORM\Mapping as ORM;


trait Contentable
{
    #[ORM\Column(type: 'text')]
    protected ?string $content;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}