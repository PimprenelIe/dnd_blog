<?php


namespace App\Helper;


use Doctrine\ORM\Mapping as ORM;


trait Trackable
{
    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $visit = 0;

    public function getVisit(): ?int
    {
        return $this->visit;
    }

    public function setVisit(?int $visit): self
    {
        $this->visit = $visit;

        return $this;
    }
}