<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'form.user.email',
                    'class' => 'form-control',
                ],
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'form.user.name',
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'form.user.description',
                    'class' => 'form-control',
                ],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
