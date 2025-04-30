<?php

// src/Form/UtilisateurType.php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\AbonnementType;
use App\Entity\Abonnement; 


class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('Prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
            ])
            ->add('DateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('NumeroTelephone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'required' => false,
            ]);
    
        if ($options['is_admin']) {
            $builder
                ->add('abonnement', AbonnementType::class, ['required' => false])
                ->add('lienJustificatif', TextType::class, [
                    'label' => 'Lien justificatif',
                    'required' => false,
                ])
                ->add('role', TextType::class, ['required' => false]);
        }
    
        // Ajoute le bouton submit à la fin
        $builder->add('submit', SubmitType::class, [
            'label' => 'Mettre à jour',
        ]);
    }    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'is_admin' => false,
        ]);
    }
}
