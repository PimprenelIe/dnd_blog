<?php

namespace App\Controller\Admin;

use App\Entity\Page\Page;
use App\Field\GoogleViewField;
use App\Field\HelpSeoField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureAssets(Assets $assets): Assets
    {
        return parent::configureAssets($assets)
            ->addJsFile('javascript/admin/help_seo.js');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Détails'),
            FormField::addPanel(false)->addCssClass('col-xl-9'),
            TextField::new('title', 'Titre')->setColumns(12),
            TextEditorField::new('content')
                ->setColumns(12)
                ->setFormType(CKEditorType::class)
                ->setFormTypeOption('config', array(
                    'height' => '100vh',
                ))

                ->hideOnIndex(),

            FormField::addPanel(false)->addCssClass('col-xl-3'),

            ChoiceField::new('type', 'Type')->setColumns(12)
            ->setChoices(array_flip(Page::TYPES))
            ,
            IntegerField::new('visit', 'Vues')->setColumns(12)->setDisabled(),
            DateTimeField::new('updatedAt', 'Date de modification')
                ->setFormat('d-MM-y H:m')->onlyOnIndex(),
            DateTimeField::new('updatedBy', 'Effectué par...')
                ->onlyOnIndex(),

            FormField::addPanel(false)->addCssClass('col-xl-12'),
            TextField::new('keywordSeo')->onlyOnForms(),
            HelpSeoField::new('helpSeo', 'Score SEO')
                ->setFormTypeOption('attr', ['data-prefix' => 'Page']),


            FormField::addTab('SEO'),
            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->setColumns(12)
                ->hideOnIndex(),
            TextField::new('metaTitle')->setColumns(12)->hideOnIndex(),
            TextField::new('metaDescription')->setColumns(12)->hideOnIndex(),
            GoogleViewField::new('googleView', false)->setColumns(12)->hideOnIndex(),

        ];
    }
}
