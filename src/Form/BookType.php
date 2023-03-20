<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Genre;
use App\Entity\Author;
use App\Entity\PublishingHouse;
use App\Form\Type\Select2Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $authors = $options['authors'];
        $genres = $options['genres'];
        $houses = $options['houses'];

        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('imageUrl')
            ->add('author', Select2Type::class,[
                'label' => 'Author',
                'required' => false,
                'class' => Author::class,
                'choices' => $authors,
                'data_length' => count($authors),
            ])
            ->add('publishingHouse', Select2Type::class,[
                'label' => 'Publishing house',
                'required' => false,
                'class' => PublishingHouse::class,
                'choices' => $houses,
                'data_length' => count($houses)
            ])
            ->add('genres', Select2Type::class,[
                'label' => 'Genres',
                'required' => false,
                'class' => Genre::class,
                'multiple' => true,
                'choices' => $genres,
                'data_length' => count($genres),
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
            'authors' => [],
            'genres' => [],
            'houses' => [],
            'mode' => 'create',
        ]);
    }
}
