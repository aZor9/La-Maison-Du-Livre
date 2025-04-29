<?php

namespace App\Form;

use App\Entity\Document;
use App\Entity\Livre;
use App\Entity\Sonore;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('annee', DateType::class, [
                'label' => 'Année',
                'required' => false,
                'widget' => 'single_text',
                'input' => 'datetime',
                'years' => range(1900, date('Y')),
            ])
            ->add('theme', TextType::class, [
                'label' => 'theme'
            ])
            // Ajout du type de document
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Livre' => 'livre',
                    'Sonore' => 'sonore',
                    'Vidéo' => 'video',
                    'Titre Periodique' => 'titreperiodique',
                ],
                'label' => 'Type de document',
            ]);

        // Ajouter des champs spécifiques en fonction du type de document
        if ($builder->getData() instanceof Livre) {
            $builder->add('isbn', TextType::class, [
                'label' => 'ISBN',
            ])
                ->add('nombrePage', TextType::class, [
                    'label' => 'Nombre de pages',
            ])
                ->add('genre', TextType::class, [
                    'label' => 'Genre',
            ]);
        } elseif ($builder->getData() instanceof Sonore) {
            $builder->add('duree', TextType::class, [
                'label' => 'duree',
            ])
                ->add('format', TextType::class, [
                    'label' => 'Format',
            ])
                ->add('interprete', TextType::class, [
                    'label' => 'Interprète',
            ]);
        } elseif ($builder->getData() instanceof Video) {
            $builder->add('realisateur', TextType::class, [
                'label' => 'Réalisateur',
            ])
                ->add('duree', TextType::class, [
                    'label' => 'Durée',
            ])
                ->add('format', TextType::class, [
                    'label' => 'Format',
            ]);
        } elseif ($builder->getData() instanceof titreperiodique) {
            $builder->add('numero', TextType::class, [
                'label' => 'Numéro',
            ])
                ->add('datepublication', TextType::class, [
                    'label' => 'Date de publication',
            ])
                ->add('format', TextType::class, [
                    'label' => 'Format',
            ]);
        }


        // Bouton de soumission
        $builder->add('submit', SubmitType::class, [
            'label' => 'Sauvegarder',
            'attr' => ['class' => 'bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
