<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

final class GoogleViewField implements FieldInterface
{
    use FieldTrait;

    /**
     * @required HelpSeoField
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
            ->setTemplatePath('admin/field/google_view.html.twig')
            ->setFormTypeOption('block_prefix', 'google_view');
    }
}