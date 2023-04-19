<?php

namespace App\Form;

use App\DTO\NumberOfBooksInCart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NumberOfBooksInCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numberOfBooks', CollectionType::class,[
                'entry_type' => IntegerType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'entry_options' => ['label' => false],
                'label' => false,
            ])
            ->add('Checkout', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NumberOfBooksInCart::class,
            'csrf_protection' => false
        ]);
    }
}
