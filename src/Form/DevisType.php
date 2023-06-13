<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\Haie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;


class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $date = date('D-m-y');

        $builder
            ->add('date', DateType::class)
            ->add('hauteur', IntegerType::class)
            ->add('longueur', IntegerType::class)
            ->add('typeClient', TextType::class)
            ->add('user', TextType::class)
            ->add('haie', TextType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
