<?php

namespace App\Form;

use App\Entity\Vente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $stockMax = $options['stock_max'] ?? null;

        $builder
            ->add('nombre', IntegerType::class, [
                'label' => 'Nombre vendu',
                'attr' => [
                    'min' => 1,
                    'max' => $stockMax,  // bloque la saisie au max du stock
                ],
                'help' => $stockMax !== null ? "Stock disponible : $stockMax" : null,
            ])
            ->add('prixUnitaire', MoneyType::class, [
                'label' => 'Prix unitaire',
                'currency' => 'XOF',
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'data' => new \DateTime(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
            'stock_max' => null, // option personnalisée pour le stock
        ]);
    }
}
