<?php

namespace App\Form;

use App\Entity\Lot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Référence Lot',
            ])
            ->add('dateEntree', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d’entrée',
            ])
            ->add('nombreInitial', IntegerType::class, [
                'label' => 'Nombre initial',
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lot::class,
        ]);
    }
}
