<?php


namespace App\Controller;


use App\Entity\Blog\Category;
use App\Entity\Blog\Keyword;
use App\Entity\Blog\Post;
use App\Repository\Blog\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{

    #[Route('/post/{slug}', name: 'post_show')]
    public function show(
        Post $post,
        PostRepository $postRepository
    ): Response
    {
        if($post->getPublishedAt() > new \DateTime()){
            throw $this->createAccessDeniedException();
        }

        $featuredPosts = $postRepository->featuredPosts($post, 3);

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'featuredPosts' => $featuredPosts
        ]);
    }

    #[Route('/category/{slug}', name: 'posts_category')]
    public function category(
        Request $request,
        Category $category,
        PaginatorInterface $paginator,
        PostRepository $postRepository
    ): Response
    {
        $pagination = $paginator->paginate(
            $postRepository->queryByCategory($category),
            $request->query->getInt('page', 1),
            13
        );

        return $this->render('post/list.html.twig', [
            'posts' => $pagination,
            'page' => $category,
            'preTitle' => "Catégorie: "
        ]);
    }

    #[Route('/keyword/{slug}', name: 'posts_keyword')]
    public function keyword(
        Request $request,
        Keyword $keyword,
        PaginatorInterface $paginator,
        PostRepository $postRepository
    ): Response
    {
        $pagination = $paginator->paginate(
            $postRepository->queryByKeyword($keyword),
            $request->query->getInt('page', 1),
            13
        );

        return $this->render('post/list.html.twig', [
            'posts' => $pagination,
            'page' => $keyword,
            'preTitle' => "Mot-clef: "
        ]);
    }

}