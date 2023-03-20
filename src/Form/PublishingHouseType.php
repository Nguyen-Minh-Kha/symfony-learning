<?php

namespace App\Form;

use App\Entity\PublishingHouse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PublishingHouseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('country')
        ;
        if ($options['mode'] === 'create') {
            $builder->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Add new Publishing House',
                ]
            );
        } else {
            $builder->add('submit', SubmitType::class, [
                'label' => 'Update Publishing House',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PublishingHouse::class,
            'mode' => 'create'
        ]);
    }
}
