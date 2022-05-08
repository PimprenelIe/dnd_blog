<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Category;
use App\Entity\Blog\Keyword;
use App\Entity\Blog\Post;
use App\Field\GoogleViewField;
use App\Field\HelpSeoField;
use App\Field\ImageChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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

    public function configureAssets(Assets $assets): Assets
    {
        return parent::configureAssets($assets)
            ->addWebpackEncoreEntry('admin_help_seo');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Détails'),
            FormField::addPanel(false)->addCssClass('col-xl-9'),
            TextField::new('title', 'Titre')->setColumns(12),
            TextEditorField::new('abstract')
                ->setColumns(12)
                ->setFormType(CKEditorType::class)
                ->hideOnIndex(),
            TextEditorField::new('content')
                ->setColumns(12)
                ->setFormType(CKEditorType::class)
                ->setFormTypeOption('config', array(
                    'height' => '100vh',
                ))

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
                        $category->getTitle(),
                        $category->countPosts()
                    );
                })
                ->setFormattedValue(static function (Category $category) {
                    return sprintf('%s (%s)',
                        $category->getTitle(),
                        $category->countPosts()
                    );
                })
                ->setColumns(12),
            AssociationField::new('keywords')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('choice_label', static function (Keyword $keyword) {
                    return sprintf('%s (%s)',
                        $keyword->getTitle(),
                        $keyword->countPosts()
                    );
                })
                ->setFormattedValue(static function (Keyword $keyword) {
                    return sprintf('%s (%s)',
                        $keyword->getTitle(),
                        $keyword->countPosts()
                    );
                })
                ->setColumns(12),


            ImageChoiceField::new('imageTitle', 'Image Titre')
                ->setFormTypeOption('attr', ['data-input' => 'imageTitle_fileName'])
                ->setColumns(12)
                ->onlyOnForms(),
            TextField::new('imageTitle.fileName')
                ->setFormTypeOption('attr', ['class' => 'imageTitle_fileName'])
                ->setFormTypeOption('row_attr', ['class' => 'd-none'])
                ->setDisabled(true)
                ->onlyOnForms(),


            FormField::addPanel(false)->addCssClass('col-xl-12'),
            TextField::new('keywordSeo')->onlyOnForms(),
            HelpSeoField::new('helpSeo', 'Score SEO')
                ->setFormTypeOption('attr', ['data-prefix' => 'Post'])
            ,


            FormField::addTab('SEO'),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->setColumns(12)
                ->hideOnIndex(),
            TextField::new('metaTitle')->setColumns(12)->hideOnIndex(),
            TextField::new('metaDescription')->setColumns(12)->hideOnIndex(),
            GoogleViewField::new('googleView', false)->setColumns(12)->hideOnIndex(),


            FormField::addTab('Commentaires'),
            CollectionField::new('comments')
                ->allowAdd(false)
            ,


        ];
    }

}
