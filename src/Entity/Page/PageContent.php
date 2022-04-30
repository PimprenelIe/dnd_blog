<?php


namespace App\Entity\Page;


use App\Helper\Contentable;
use App\Helper\Metable;
use App\Helper\SeoAnalysable;
use App\Helper\Sluggable;
use App\Helper\Trackable;
use Doctrine\ORM\Mapping as ORM;


abstract class PageContent
{
    use Contentable;
    use Sluggable;
    use SeoAnalysable;
    use Metable;
    use Trackable;

}