<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Author;
use App\DTO\SearchBookCriteria;
use App\Entity\PublishingHouse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => false,
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'required' => false,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'required' => false,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('minPrice',MoneyType::class, [
                'required' => false,
            ])
            ->add('maxPrice', MoneyType::class, [
                'required' => false,
            ])
            ->add('publishingHouses', EntityType::class, [
                "class" => PublishingHouse::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
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
