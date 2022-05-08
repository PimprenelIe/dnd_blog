<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class HelpSeoField implements FieldInterface
{
    use FieldTrait;

    /**
     * @required'assets/javascript/admin/help_seo.js'
     *
     * @param string $propertyName
     * @param false $label
     * @return static
     */
    public static function new(string $propertyName, $label = false): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/help_seo.html.twig')
            ->setFormTypeOption('block_prefix', 'help_seo')
            ;
    }
}