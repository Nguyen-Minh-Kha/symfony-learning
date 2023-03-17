<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Author;
use App\DTO\SearchBookCriteria;
use App\Entity\PublishingHouse;
use App\Form\Type\Select2Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $authors = $options['data']->authors;
        $houses = $options['data']->publishingHouses;
        $genres = $options['data']->genres;
        $builder
            ->add('title', TextType::class, [
                'required' => false,
            ])
            ->add('authors', Select2Type::class, [
                'class' => Author::class,
                'required' => false,
                'multiple' => true,
                'choices' => $authors,
                'data_length' => count($authors),
            ])
            ->add('genres', Select2Type::class, [
                'class' => Genre::class,
                'required' => false,
                'multiple' => true,
                'choices' => $genres,
                'data_length' => count($genres),
            ])
            ->add('minPrice',MoneyType::class, [
                'required' => false,
            ])
            ->add('maxPrice', MoneyType::class, [
                'required' => false,
            ])
            ->add('publishingHouses', Select2Type::class, [
                "class" => PublishingHouse::class,
                'multiple' => true,
                'required' => false,
                'choices' => $houses,
                'data_length' => count($houses)
            ])
            ->add('orderBy', ChoiceType::class, [
                'choices' => [
                    'Id' => 'id',
                    'Title' => 'title',
                    'Price' => 'price'
                ],
                'required' => true,
            ])
            ->add('direction', ChoiceType::class, [
                'choices' => [
                    'Ascending' => 'ASC',
                    'Descending' => 'DESC',
                ],
                'required' => 'true',
            ])
            ->add('search', SubmitType::class,[
                'label' => 'search'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchBookCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
