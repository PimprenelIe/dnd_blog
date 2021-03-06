<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Category;
use App\Entity\Blog\Comment;
use App\Entity\Blog\Keyword;
use App\Entity\Blog\Post;
use App\Entity\Media\Media;
use App\Entity\Page\Page;
use App\Entity\User;
use App\Entity\Visite;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $lastPosts = $this->entityManager->getRepository(Post::class)
            ->findBy([], ['createdAt' => "DESC"], 3);

        $statsVisites = $this->entityManager->getRepository(Visite::class)
            ->findNbVisiteLastDays();


        return $this->render('admin/dashboard.html.twig');
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dnd Blog');
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->addFormTheme('admin/form/help_seo.html.twig')
            ->addFormTheme('admin/form/google_view.html.twig')
            ->addFormTheme('admin/form/image_choice.html.twig');
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin_google_view')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Site');
        yield MenuItem::linkToCrud('Pages', 'fa fa-scroll', Page::class);

        yield MenuItem::section('Blog');
        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Category::class);
        yield MenuItem::linkToCrud('Posts', 'fa fa-file-text', Post::class);
        yield MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Comment::class);
        yield MenuItem::linkToCrud('Keywords', 'fas fa-search', Keyword::class);

        yield MenuItem::section('Media');
        yield MenuItem::linkToCrud('Image', 'fas fa-image', Media::class);

        yield MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', User::class);
    }
}
