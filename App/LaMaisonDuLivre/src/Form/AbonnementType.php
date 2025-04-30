<?php

// src/Form/AbonnementType.php

namespace App\Form;

use App\Entity\Abonnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AbonnementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statutAbonnement', ChoiceType::class, [
                'label' => 'Statut de l\'abonnement',
                'choices' => [
                    'Aucun abonnement' => 'aucun abonnement',
                    'En cours (1 an)' => 'en cours (1an)',
                    'En cours (6 mois)' => 'en cours (6mois)',
                ],
                'required' => false,
            ])
            ->add('dateAbonnement', DateType::class, [
                'label' => 'Date de début de l\'abonnement',
                'widget' => 'single_text',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
