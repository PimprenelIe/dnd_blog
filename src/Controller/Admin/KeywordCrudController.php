<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Keyword;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class KeywordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Keyword::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('keyword'),
            SlugField::new('slug')->setTargetFieldName('keyword'),
            IntegerField::new('countPosts')->setDisabled()
        ];
    }

}
