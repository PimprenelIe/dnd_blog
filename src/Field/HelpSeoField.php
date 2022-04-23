<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class HelpSeoField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, $label = false): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/help_seo.html.twig')
            ->setFormTypeOption('block_prefix', 'help_seo')
            ->addJsFiles('javascript/admin/help_seo.js');
    }
}