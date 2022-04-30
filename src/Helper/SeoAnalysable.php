<?php


namespace App\Helper;


use Doctrine\ORM\Mapping as ORM;


trait SeoAnalysable
{
    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    protected ?string $keywordSeo;

    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $helpSeo;


    protected ?int $googleView;

    public function getKeywordSeo(): ?string
    {
        return $this->keywordSeo;
    }

    public function setKeywordSeo(?string $keywordSeo): self
    {
        $this->keywordSeo = $keywordSeo;

        return $this;
    }

    public function getHelpSeo(): ?int
    {
        return $this->helpSeo;
    }

    public function setHelpSeo(?int $helpSeo): self
    {
        $this->helpSeo = $helpSeo;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGoogleView(): ?int
    {
        return $this->googleView;
    }

    /**
     * @param int|null $googleView
     */
    public function setGoogleView(?int $googleView): void
    {
        $this->googleView = $googleView;
    }


}