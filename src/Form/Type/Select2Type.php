<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class Select2Type extends AbstractType
{

    public function getParent()
    {
        return EntityType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver   ->setRequired(['choices'])
                    ->setDefaults([
                        'data_length' => '',
                    ]);

    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['choices'] = $options['choices'];

        $view->vars['data_length'] = $options['data_length'];
    }

    public function getName()
    {
        return 'select2';
    }

}