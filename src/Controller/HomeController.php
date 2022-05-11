<?php


namespace App\Controller;


use App\Repository\Blog\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'home', options: ['sitemap' => ['section' => 'site']])]
    public function home(
        Request $request,
        PaginatorInterface $paginator,
        PostRepository $postRepository
    ): Response
    {
        // Les 4 premiers articles de la page
        $lastPosts = $postRepository->findWithDateBy([], ['publishedAt' => 'DESC'], 4);

        // Le reste des articles avec une pagination
        $pagination = $paginator->paginate(
            $postRepository->queryWithDateBy([],['publishedAt' => 'DESC'],null, 4),
            $request->query->getInt('page', 1),
            13
        );

        return $this->render('home.html.twig', [
            'lastPosts' => $lastPosts,
            'posts' => $pagination
        ]);
    }

}