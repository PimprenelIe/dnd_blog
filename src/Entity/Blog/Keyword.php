<?php

namespace App\Entity\Blog;

use App\Entity\Page\PageContent;
use App\Repository\Blog\KeywordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: KeywordRepository::class)]
class Keyword extends PageContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'keywords')]
    private $posts;

    #[Pure] public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function __toString(){
        return $this->title;
    }

    public function countPosts(): int
    {
        return $this->posts->count();
    }

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

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addKeyword($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            $post->removeKeyword($this);
        }

        return $this;
    }
}
