<?php

namespace App\Form;

use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description');
        if ($options['mode'] === 'create') {
            $builder->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Add new Genre',
                ]
            );
        } else {
            $builder->add('submit', SubmitType::class, [
                'label' => 'Update Genre',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Genre::class,
            'mode' => 'create',
        ]);
    }
}
