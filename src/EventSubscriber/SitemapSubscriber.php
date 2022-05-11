<?php


namespace App\EventSubscriber;


use App\Entity\Page\Page;
use App\Entity\Page\PageContent;
use App\Repository\Blog\CategoryRepository;
use App\Repository\Blog\KeywordRepository;
use App\Repository\Blog\PostRepository;
use App\Repository\Page\PageRepository;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapSubscriber implements EventSubscriberInterface
{

    /**
     * @var PostRepository
     */
    private PostRepository $postRepository;
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;
    /**
     * @var KeywordRepository
     */
    private KeywordRepository $keywordRepository;
    /**
     * @var PageRepository
     */
    private PageRepository $pageRepository;

    public function __construct(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        KeywordRepository $keywordRepository,
        PageRepository $pageRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->keywordRepository = $keywordRepository;
        $this->pageRepository = $pageRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerPostsUrls($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerCategoriesUrls($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerKeywordsUrls($event->getUrlContainer(), $event->getUrlGenerator());
        $this->registerSimplePagesUrls($event->getUrlContainer(), $event->getUrlGenerator());
    }

    /**
     * @param UrlContainerInterface $urls
     * @param UrlGeneratorInterface $router
     */
    public function registerSimplePagesUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $pages = $this->pageRepository->findBy(["type" => Page::TYPE_SIMPLE]);

        foreach ($pages as $page) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'page_show',
                        ['slug' => $page->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'site'
            );
        }
    }

    /**
     * @param UrlContainerInterface $urls
     * @param UrlGeneratorInterface $router
     */
    public function registerPostsUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $posts = $this->postRepository->findWithDateBy([]);

        foreach ($posts as $post) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'post_show',
                        ['slug' => $post->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'blog'
            );
        }
    }

    /**
     * @param UrlContainerInterface $urls
     * @param UrlGeneratorInterface $router
     */
    public function registerCategoriesUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $categories = $this->categoryRepository->findAll();

        foreach ($categories as $category) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'posts_category',
                        ['slug' => $category->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'blog'
            );
        }
    }

    /**
     * @param UrlContainerInterface $urls
     * @param UrlGeneratorInterface $router
     */
    public function registerKeywordsUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $keywords = $this->keywordRepository->findAll();

        foreach ($keywords as $keyword) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'posts_keyword',
                        ['slug' => $keyword->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'blog'
            );
        }
    }
}