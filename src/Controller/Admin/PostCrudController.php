<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Category;
use App\Entity\Blog\Keyword;
use App\Entity\Blog\Post;
use App\Field\HelpSeoField;
use App\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Détails'),
            FormField::addPanel(false)->addCssClass('col-xl-9'),
            TextField::new('title', 'Titre')->setColumns(6),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->setColumns(6)
                ->hideOnIndex(),
            TextEditorField::new('abstract')
                ->setColumns(12)
                ->setFormType(CKEditorType::class)
                ->hideOnIndex(),
            TextEditorField::new('content')
                ->setColumns(12)
                ->setFormType(CKEditorType::class)
                ->setFormTypeOption('config', array('height' => '100vh'))
                ->hideOnIndex(),

            FormField::addPanel(false)->addCssClass('col-xl-3'),

            IntegerField::new('visit', 'Vues')->setColumns(12)->setDisabled(),
            BooleanField::new('active', 'Actif'),
            DateTimeField::new('publishedAt', 'Date de publication')
                ->setFormat('d-MM-y H:m'),
            DateTimeField::new('updatedAt', 'Date de modification')
                ->setFormat('d-MM-y H:m')->onlyOnIndex(),
            DateTimeField::new('updatedBy', 'Effectué par...')
                ->onlyOnIndex(),

            AssociationField::new('categories')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('choice_label', static function (Category $category) {
                    return sprintf('%s (%s)',
                        $category->getName(),
                        $category->countPosts()
                    );
                })
                ->setFormattedValue(static function (Category $category) {
                    return sprintf('%s (%s)',
                        $category->getName(),
                        $category->countPosts()
                    );
                })
                ->setColumns(12),
            AssociationField::new('keywords')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('choice_label', static function (Keyword $keyword) {
                    return sprintf('%s (%s)',
                        $keyword->getKeyword(),
                        $keyword->countPosts()
                    );
                })
                ->setFormattedValue(static function (Keyword $keyword) {
                    return sprintf('%s (%s)',
                        $keyword->getKeyword(),
                        $keyword->countPosts()
                    );
                })
                ->setColumns(12),

            FormField::addPanel(false)->addCssClass('col-xl-12'),
            TextField::new('keywordSeo')->onlyOnForms(),
            HelpSeoField::new('helpSeo', 'Score SEO'),


            FormField::addTab('SEO'),
            TextField::new('metaTitle')->hideOnIndex(),
            TextField::new('metaDescription')->hideOnIndex(),
//            VichImageField::new('imageTitle.fileName')->hideOnForm(),
//            VichImageField::new('imageTitle.file')->onlyOnForms(),

            FormField::addTab('Commentaires'),
            CollectionField::new('comments')
                ->allowAdd(false)
            ,


        ];
    }

}
