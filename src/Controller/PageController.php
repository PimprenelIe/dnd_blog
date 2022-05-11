<?php


namespace App\Controller;

use App\Entity\Page\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{

    /**
     * @Route("/{slug}", name="page_show", priority=-1)
     * @param Page $page
     * @return Response
     */
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