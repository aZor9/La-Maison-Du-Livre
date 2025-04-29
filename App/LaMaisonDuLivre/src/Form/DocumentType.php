<?php
// src/Form/DocumentType.php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('annee', DateType::class, [
                'label' => 'Année',
                'required' => false,
                'widget' => 'single_text', // Champ avec un seul champ de texte
                'input' => 'datetime',     // Précise que l'input est une DateTime
            ])
            ->add('theme', TextType::class, [
                'label' => 'Thème',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => ['class' => 'bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}

