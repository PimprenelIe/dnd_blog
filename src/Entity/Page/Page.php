<?php

namespace App\Entity\Page;

use App\Helper\Timestampable;
use App\Helper\Userable;
use App\Repository\Page\PageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Page extends PageContent
{
    public const TYPE_SIMPLE = 0;
    public const TYPE_ACCUEIL = 1;
    public const TYPE_BLOG = 2;
    public const TYPE_CONTACT = 3;

    public const TYPES = [
        self::TYPE_SIMPLE => 'Simple',
        self::TYPE_ACCUEIL => 'Accueil',
        self::TYPE_BLOG => 'Blog',
        self::TYPE_CONTACT => 'Formulaire contact',
    ];

    use Timestampable;
    use Userable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title;

    #[ORM\Column(type: 'integer')]
    private int $type = self::TYPE_SIMPLE;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }
}
