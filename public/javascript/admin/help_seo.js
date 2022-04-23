let keyword = "";
let nbWordsInBody = 0;
let idKeywordSeo = 'Post_keywordSeo';
let idTitle = 'Post_title';
let idContent = 'Post_content';
let idMetaTitle = 'Post_metaTitle';
let idMetaDescription = 'Post_metaDescription';
let idSlug = 'Post_slug';


document.addEventListener('DOMContentLoaded', function () {

    let elementKeywordSeo = document.getElementById(idKeywordSeo);
    keyword = elementKeywordSeo.value;

    update();

    ['keyup', 'paste', 'change'].forEach(function (e) {
        elementKeywordSeo.addEventListener(e, onChange);
    });

}, false);


function onChange(e){
    keyword = e.target.value;
    update();
}

function update() {
    changeMessage(document.getElementById(idContent).value);
    changeDescription(document.getElementById(idTitle).value);
    changeTitreMeta(document.getElementById(idMetaTitle).value);
    changeSlug(document.getElementById(idSlug).value);
    changeAbstract(document.getElementById(idMetaDescription).value);

    if (document.querySelectorAll('.red:not(.d-none)').length > 0) {
        document.getElementById('Post_helpSeo').value = 0;
    } else if (document.querySelectorAll('.orange:not(.d-none)').length > 0) {
        document.getElementById('Post_helpSeo').value = 1;
    } else {
        document.getElementById('Post_helpSeo').value = 2;
    }

}

function changeMessage($content) {
    keywordSubTitle($content);
    nbWordsParagraph($content);
    image($content);
    internLink($content);
    externLink($content);
    keywordFirstParagraph($content);

    $content = $content.replace(/(^\s*)|(\s*$)/gi, "");
    $content = $content.replace(/[ ]{2,}/gi, " ");
    $content = $content.replace(/\n /, "\n");

    nbWords($content);
    keywordDensity($content);
}


//
//
// document.querySelector(document).ready(function () {
//
//     // keyword = document.querySelector('#Post_keywordSeo').val();
//     document.querySelector('#Post_keywordSeo').on("keyup paste change", function () {
//         keyword = document.querySelector(this).val();
//         changeMessage(document.querySelector('#Post_content').val());
//         changeDescription(document.querySelector('#Post_title').val());
//         changetitreMeta(document.querySelector('#Post_metaTitle').val());
//         changeSlug(document.querySelector('#Post_slug').val());
//         changeAbstract(document.querySelector('#Post_metaDescription').val());
//     })
//
//     /**
//      * Modification du texte principal
//      */
//     changeMessage(document.querySelector('#Post_content').innerHTML);
//     document.querySelector('#Post_content').on('change keyup paste', function () {
//         changeMessage(document.querySelector(this).innerHtml);
//     });
//
//
//     // changeMessage(CKEDITOR.instances["Post_content"].getData());
//     //
//     // CKEDITOR.instances["Post_content"].on('change', function() {
//     //     changeMessage(CKEDITOR.instances["Post_content"].getData());
//     // });
//
//
//     /**
//      * Modification du titre de l'article
//      */
//     changeDescription(document.querySelector('#Post_title').val());
//     document.querySelector('#Post_title').on('change keyup paste', function () {
//         changeDescription(document.querySelector(this).val());
//     });
//
//     /**
//      * Modification du meta titre de l'article
//      */
//     changetitreMeta(document.querySelector('#Post_metaTitle').val());
//     document.querySelector('#Post_metaTitle').on('change keyup paste', function () {
//         changetitreMeta(document.querySelector(this).val());
//     });
//
//     /**
//      * Modification du slug
//      */
//     changeSlug(document.querySelector('#Post_slug').val());
//     document.querySelector('#Post_slug').on('change keyup paste', function () {
//         changeSlug(document.querySelector(this).val());
//     });
//
//     /**
//      * Modification de la meta description
//      */
//     changeAbstract(document.querySelector('#Post_metaDescription').val());
//     document.querySelector('#Post_metaDescription').on('change keyup paste', function () {
//         changeAbstract(document.querySelector(this).val());
//     });
//
// });
//

function changeDescription($val) {
    keywordIn($val.toLowerCase(), "keywordTitle");
}

function changeTitreMeta($val) {
    // if ($val.length < 1) {
    //     document.querySelector('.results .titre').innerHTML = "Meta-titre sinon titre de mon article par défaut";
    // } else {
    //     document.querySelector('.results .titre').innerHTML = $val;
    // }
    meta($val.toLowerCase(), "titreMeta");
}

function changeSlug($val) {
    let $slug = $val;
    // if ($slug.length < 1) {
    //     document.querySelector('.results .slug').innerHTML = " › actualites › url-de-mon-article...";
    // } else {
    //
    //     $slug = '/actualites/' + $slug;
    //     $slug = $slug.replaceAll("/", ' > ');
    //     if ($slug.length > 40) {
    //         $slug = $slug.substr(0, 40) + "...";
    //     } else {
    //         $slug = $slug.substr(0, 40);
    //     }
    //     document.querySelector('.results .slug').innerHTML = $slug;
    // }

    keywordInSlug($slug, "slug");
}

function changeAbstract($val) {
    let $abstract = $val;
    if ($abstract.length < 1) {
        $abstract = "<em>Meta-description sinon :</em> Site officiel de la <strong>SPA</strong> de <strong>Strasbourg</strong>. Adopter un animal est une responsabilité.";
        meta("", "descriptionMeta");

    } else {
        if ($abstract.length > 170) {
            $abstract = $abstract.substr(0, 170) + "...";
        } else {
            $abstract = $abstract.substr(0, 170);
        }
        meta($abstract.toLowerCase(), "descriptionMeta");
    }
    // document.querySelector('.results .description').innerHTML = $abstract;
}


function nbWords($content) {

    nbWordsInBody = $content.split(' ').length;

    let elements = document.querySelectorAll('.words');
    [].forEach.call(elements, function (element) {
        element.innerHTML = nbWordsInBody;
    });
    if (nbWordsInBody < 300) {
        document.querySelector('.nbWords.green').classList.add('d-none');
        document.querySelector('.nbWords.red').classList.remove('d-none');
    } else {
        document.querySelector('.nbWords.red').classList.add('d-none');
        document.querySelector('.nbWords.green').classList.remove('d-none');
    }

}

function image($content) {

    if (!$content.includes("<img")) {
        document.querySelector('.image.green').classList.add('d-none');
        document.querySelector('.image.red').classList.remove('d-none');
    } else {
        document.querySelector('.image.red').classList.add('d-none');
        document.querySelector('.image.green').classList.remove('d-none');
    }
}


function meta($content, $class) {
    if ($content.length < 1) {
        document.querySelector('.' + $class + '.red').classList.remove('d-none');

        document.querySelector('.' + $class + '.red2').classList.add('d-none');
        document.querySelector('.' + $class + '.orange').classList.add('d-none');
        document.querySelector('.' + $class + '.green').classList.add('d-none');
        document.querySelector('.' + $class + '.green2').classList.add('d-none');

    } else {

        document.querySelector('.' + $class + '.red').classList.add('d-none');

        if (keyword.length < 3 || !$content.toLowerCase().includes(keyword)) {
            document.querySelector('.' + $class + '.red2').classList.remove('d-none');
            document.querySelector('.' + $class + '.green').classList.add('d-none');
        } else {
            document.querySelector('.' + $class + '.red2').classList.add('d-none');
            document.querySelector('.' + $class + '.green').classList.remove('d-none');

        }

        if ($content.length < 120) {
            document.querySelector('.' + $class + '.orange').classList.remove('d-none');
            document.querySelector('.' + $class + '.green2').classList.add('d-none');

        } else {
            document.querySelector('.' + $class + '.orange').classList.add('d-none');
            document.querySelector('.' + $class + '.green2').classList.remove('d-none');

        }
    }
}

function internLink($content) {

    if ($content.includes("href='/") || $content.includes('href="/')) {
        document.querySelector('.internLink.green').classList.remove('d-none');
        document.querySelector('.internLink.red').classList.add('d-none');
    } else {
        document.querySelector('.internLink.red').classList.remove('d-none');
        document.querySelector('.internLink.green').classList.add('d-none');
    }

}

function externLink($content) {

    if (($content.includes("href='http") || $content.includes('href="http'))) {
        document.querySelector('.externLink.green').classList.remove('d-none');
        document.querySelector('.externLink.orange').classList.add('d-none');
    } else {
        document.querySelector('.externLink.orange').classList.remove('d-none');
        document.querySelector('.externLink.green').classList.add('d-none');
    }

}

function keywordFirstParagraph($content) {

    $indexFinParagraph = $content.indexOf("</p>");
    if ($indexFinParagraph > 0) {
        $firstParagraph = $content.substring(0, $indexFinParagraph);

        if (keyword.length < 3 || !$firstParagraph.toLowerCase().includes(keyword)) {
            document.querySelector('.keywordFirstParagraph.red').classList.remove('d-none');
            document.querySelector('.keywordFirstParagraph.green').classList.add('d-none');
        } else {
            document.querySelector('.keywordFirstParagraph.red').classList.add('d-none');
            document.querySelector('.keywordFirstParagraph.green').classList.remove('d-none');
        }

    }


}


function keywordIn($content, $class) {
    if ($content.length > 0) {
        if (keyword.length < 3 || !$content.toLowerCase().includes(keyword)) {
            document.querySelector('.' + $class + '.red').classList.remove('d-none');
            document.querySelector('.' + $class + '.green').classList.add('d-none');
        } else {
            document.querySelector('.' + $class + '.red').classList.add('d-none');
            document.querySelector('.' + $class + '.green').classList.remove('d-none');
        }
    }
}

function keywordInSlug($content, $class) {
    if ($content.length > 0 && keyword.length > 3 && $content.toLowerCase().includes(keyword)) {
        document.querySelector('.' + $class + '.orange').classList.add('d-none');
        document.querySelector('.' + $class + '.green').classList.remove('d-none');
        return;
    }

    document.querySelector('.' + $class + '.orange').classList.remove('d-none');
    document.querySelector('.' + $class + '.green').classList.add('d-none');
}

function keywordDensity($content) {
    let densityElements = document.querySelectorAll('.density');
    let nbKeywordElements = document.querySelectorAll('.nbKeyword');

    if (keyword.length > 3) {
        var reg = new RegExp(keyword, 'g')
        let nbKeyword = ($content.match(reg) || []).length;
        let density = ((nbKeyword / nbWordsInBody) * 100).toFixed(2);


        [].forEach.call(densityElements, function (element) {
            element.innerHTML = density;
        });

        [].forEach.call(nbKeywordElements, function (element) {
            element.innerHTML = nbKeyword;
        });

        if (parseFloat(density) > 0) {
            if (parseFloat(density) > 2.5) {

                document.querySelector('.keywordDensity.red').classList.add('d-none');
                document.querySelector('.keywordDensity.red2').classList.remove('d-none');
                document.querySelector('.keywordDensity.green').classList.add('d-none');
                return;
            }

            document.querySelector('.keywordDensity.red').classList.add('d-none');
            document.querySelector('.keywordDensity.red2').classList.add('d-none');
            document.querySelector('.keywordDensity.green').classList.remove('d-none');
            return;
        }
    }

    [].forEach.call(densityElements, function (element) {
        element.innerHTML = 0;
    });

    [].forEach.call(nbKeywordElements, function (element) {
        element.innerHTML = 0;
    });

    document.querySelector('.keywordDensity.red').classList.remove('d-none');
    document.querySelector('.keywordDensity.red2').classList.add('d-none');
    document.querySelector('.keywordDensity.green').classList.add('d-none');

}

function keywordSubTitle($content) {

    let $headings = $content.match(/<h[^>]+>(.*)<\/h[^>]+>/g);

    if ($headings !== null) {
        document.querySelector('.keywordSubTitle.red').classList.add('d-none');
        if (keyword.length > 3) {
            for (const element of $headings) {
                if (element.toLowerCase().includes(keyword)) {
                    document.querySelector('.keywordSubTitle.green').classList.remove('d-none');
                    document.querySelector('.keywordSubTitle.orange').classList.add('d-none');
                    return;
                }
            }
        }
        document.querySelector('.keywordSubTitle.green').classList.add('d-none');
        document.querySelector('.keywordSubTitle.orange').classList.remove('d-none');
    } else {
        document.querySelector('.keywordSubTitle.red').classList.remove('d-none');
        document.querySelector('.keywordSubTitle.orange').classList.add('d-none');
        document.querySelector('.keywordSubTitle.green').classList.add('d-none');
    }
}

function nbWordsParagraph($content) {

    let $paragraph = $content.match(/<p>(.*)<\/p>/g);

    if ($paragraph !== null) {
        for (const element of $paragraph) {
            let nbWordsInParagraph = element.split(' ').length;

            if (nbWordsInParagraph > 150) {
                document.querySelector('.nbWordsParagraph.red').classList.remove('d-none');
                document.querySelector('.nbWordsParagraph.green').classList.add('d-none');
                return;
            }
        }
    }

    document.querySelector('.nbWordsParagraph.red').classList.add('d-none');
    document.querySelector('.nbWordsParagraph.green').classList.remove('d-none');

}