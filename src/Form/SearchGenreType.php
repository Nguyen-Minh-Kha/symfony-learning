<?php

namespace App\Form;

use App\DTO\SearchGenreCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchGenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'required' => false,
        ])
            ->add('orderBy', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'id' => 'id', 
                    'title' => 'title'
                ],
            ])
            ->add('direction', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Descending' => 'DESC',
                    'Ascending' => 'ASC'
                ]
            ])
            ->add('send', SubmitType::class
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchGenreCriteria::class,
        ]);
    }
}
