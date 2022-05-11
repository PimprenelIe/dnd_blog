<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{

    public const TEST_VALUE = '{5yjAc~*4)ZH9j98bF';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('information', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email(['mode' => 'strict']),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Merci d\'écrire votre message',
                'required' => true,
            ])
            ->add('rgpd', CheckboxType::class, [
                'required' => true,
            ])
            ->add('test1', TextType::class, [
                'required' => true,
                'data' => self::TEST_VALUE
            ])
            ->add('test2', TextType::class, [
                'required' => true,
            ])
            ->add('send', SubmitType::class,[
                'label' => 'Envoyer'
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
