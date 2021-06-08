<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname',TextType::class,['label' =>  'Nom & prénom'])
            ->add('username',TextType::class,['label' =>  'Pseudo'])
            ->add('email',EmailType::class,['label' =>  'Email'])
            ->add('confirmPassword',RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options' =>['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation']
                ])
            ->add('Valider',SubmitType::class)
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
