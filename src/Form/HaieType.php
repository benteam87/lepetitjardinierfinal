<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Haie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HaieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('nom')
            ->add('prix')
            ->add('categorie', EntityType::class, array(
                'label' => 'Catégorie haie',
                'class' => Categorie::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisissez une catégorie',
                'required' => true,))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Haie::class,
        ]);
    }
}
