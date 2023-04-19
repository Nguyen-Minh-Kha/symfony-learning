<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('firstname')
            ->add('lastname')
            ->add('image_url')
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'expanded' => true,
                'multiple' => true,
                'choices' => [
                    'user' => "ROLE_USER", 
                    'admin' => "ROLE_ADMIN"
                ],
            ]);

            

        

        

        if ($options['mode'] === 'create') {

            $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
            
                function ($rolesArray) {
                    // transform the array to a string
                    return count((array)$rolesArray)? $rolesArray[0] : null;
                },
            function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                },
            
            ));

            $builder->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Add new User',
                ]
            );
        } else {
            $builder->add('submit', SubmitType::class, [
                'label' => 'Update User',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'mode' => 'create',
        ]);
    }
}
