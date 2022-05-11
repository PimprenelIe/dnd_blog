<?php


namespace App\Controller;

use App\Entity\Page\Page;
use App\Repository\Page\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{


    #[Route('/contact', name: 'contact', options: ['sitemap' => ['section' => 'site']])]
    public function pageContact(
        Request $request,
        PageRepository $pageRepository
    ): Response
    {

        $page = $pageRepository->findOneBy(['type' => Page::TYPE_CONTACT]);

        return $this->render('page/contact.html.twig', [
            'page' => $page
        ]);
    }

    #[Route('/{slug}', name: 'page_show', priority: -1)]
    public function page(
        Page $page
    ): Response
    {

        if($page->getType() !== Page::TYPE_SIMPLE){
            return $this->redirectToRoute('home');
        }

        return $this->render('page/show.html.twig', [
            'page' => $page
        ]);
    }


}