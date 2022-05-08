<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Category;
use App\Field\GoogleViewField;
use App\Field\HelpSeoField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
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
            TextField::new('title')->setColumns(6),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->setColumns(6)
                ->hideOnIndex(),
            TextEditorField::new('content')
                ->setColumns(12)
                ->setFormType(CKEditorType::class)
                ->setFormTypeOption('config', array('height' => '100vh'))
                ->hideOnIndex(),

            FormField::addPanel(false)->addCssClass('col-xl-3'),
            IntegerField::new('countPosts')->setColumns(12)->setDisabled(),
            IntegerField::new('visit', 'Vues')->setColumns(12)->setDisabled(),




            FormField::addPanel(false)->addCssClass('col-xl-12'),
            TextField::new('keywordSeo')->onlyOnForms(),
            HelpSeoField::new('helpSeo', 'Score SEO')
                ->setFormTypeOption('attr', ['data-prefix' => 'Category']),



            FormField::addTab('SEO'),
            TextField::new('metaTitle')->hideOnIndex(),
            TextField::new('metaDescription')->hideOnIndex(),
            GoogleViewField::new('googleView', false)->setColumns(12)->hideOnIndex(),

        ];
    }

}
