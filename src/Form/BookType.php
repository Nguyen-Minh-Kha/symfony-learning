<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Author;
use App\Entity\PublishingHouse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('imageUrl')
            ->add('author', EntityType::class,[
                'label' => 'choose author',
                'required' => false,
                'class' => Author::class,
                'choice_label' => 'name'
            ])
            ->add('publishingHouse', EntityType::class,[
                'label' => 'choose publishingHouse',
                'required' => false,
                'class' => PublishingHouse::class,
                'choice_label' => 'name'
            ])
            ->add('genres', EntityType::class,[
                'label' => 'choose genres',
                'required' => false,
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
        ;
        if ($options['mode'] === 'create') {
            $builder->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Add new book',
                ]
            );
        } else {
            $builder->add('submit', SubmitType::class, [
                'label' => 'Update Book',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'mode' => 'create',
        ]);
    }
}
