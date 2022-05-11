<?php


namespace App\Service;


class HtmlFunctions
{
    public static function detectTags($string)
    {

        // Pas de code de la forme <tag attr=XXX>texte</tag>
        $testHTML = preg_match('/<[^>]+>/', $string);

        // Pas de code de la forme [tag attr=XXX]
        $testTag = preg_match('/[[^>]+]/', $string);

        // pas de lien commençant par http://…
        $testURL = strstr($string, 'http://');

        if (($testHTML || $testTag) || $testURL) {
            return true;
        }
        return false;
    }
}