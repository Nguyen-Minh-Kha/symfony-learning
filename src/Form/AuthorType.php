<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('imageUrl')
        ;
        if ($options['mode'] === 'create') {
            $builder->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Add new Author',
                ]
            );
        } else {
            $builder->add('submit', SubmitType::class, [
                'label' => 'Update Author',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'mode' => 'create',
        ]);
    }
}
