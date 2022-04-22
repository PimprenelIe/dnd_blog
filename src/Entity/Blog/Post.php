<?php

namespace App\Entity\Blog;

use App\Entity\Media\Media;
use App\Helper\Timestampable;
use App\Helper\Userable;
use App\Repository\Blog\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    use Timestampable;
    use Userable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $abstract;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'boolean')]
    private $draft;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $publishedAt;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $visit;

    #[ORM\Column(type: 'string', length: 70, nullable: true)]
    private $metaTitle;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $metaDescription;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $keywordSeo;

    #[ORM\ManyToOne(targetEntity: Media::class, inversedBy: 'posts')]
    private $imageTitle;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    private $categories;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\ManyToMany(targetEntity: Keyword::class, inversedBy: 'posts')]
    private $keywords;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->keywords = new ArrayCollection();
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

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDraft(): ?bool
    {
        return $this->draft;
    }

    public function setDraft(bool $draft): self
    {
        $this->draft = $draft;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getVisit(): ?int
    {
        return $this->visit;
    }

    public function setVisit(?int $visit): self
    {
        $this->visit = $visit;

        return $this;
    }

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

    public function getKeywordSeo(): ?string
    {
        return $this->keywordSeo;
    }

    public function setKeywordSeo(?string $keywordSeo): self
    {
        $this->keywordSeo = $keywordSeo;

        return $this;
    }

    public function getImageTitle(): ?Media
    {
        return $this->imageTitle;
    }

    public function setImageTitle(?Media $imageTitle): self
    {
        $this->imageTitle = $imageTitle;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Keyword>
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(Keyword $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
        }

        return $this;
    }

    public function removeKeyword(Keyword $keyword): self
    {
        $this->keywords->removeElement($keyword);

        return $this;
    }
}
