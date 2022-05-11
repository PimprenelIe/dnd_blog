<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FilterHtmlExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return array(
            new TwigFunction('stripHtmlTags', array($this, 'stripHtmlTags')),
        );
    }

    public function stripHtmlTags($value)
    {
        return html_entity_decode(htmlspecialchars_decode(strip_tags($value), ENT_QUOTES));
    }

}