<?php

namespace App\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class ImageChoiceField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, $label = false): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/vich_image.html.twig')
            ->setFormTypeOption('block_prefix', 'image_choice')
            ;

    }
}