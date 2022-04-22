<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Post;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            SlugField::new('slug')->hideOnIndex(),
            TextEditorField::new('abstract'),
            TextEditorField::new('content')->hideOnIndex(),
            BooleanField::new('draft'),
            BooleanField::new('active'),
            DateTimeField::new('publishedAt'),
            IntegerField::new('visit'),
            TextField::new('metaTitle')->hideOnIndex(),
            TextField::new('metaDescription')->hideOnIndex(),
            TextField::new('keywordSeo')->hideOnIndex(),
            VichImageField::new('imageTitle.fileName')->hideOnForm(),
            VichImageField::new('imageTitle.file')->onlyOnForms(),
            CollectionField::new('categories')->onlyOnForms(),
            CollectionField::new('comments')->onlyOnForms(),
            CollectionField::new('keywords')->onlyOnForms(),
        ];
    }

}
