<?php 

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentcreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500'],
            ])
            ->add('annee', DateType::class, [
                'label' => 'Année',
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500'],
            ])
            ->add('theme', TextType::class, [
                'label' => 'Thème',
                'attr' => ['class' => 'w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500'],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de document',
                'choices' => [
                    'Livre' => 'livre',
                    'Sonore' => 'sonore',
                    'Vidéo' => 'video',
                    'Titre Periodique' => 'titreperiodique',
                ],
                'expanded' => true, // Affiche sous forme de boutons radio
                'multiple' => false, // Une seule sélection possible
                'mapped' => false, // Ne pas lier ce champ à l'entité Document
                'attr' => ['class' => 'space-y-2'],
            ])
            ->add('auteurs', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => function (Auteur $auteur) {
                    return $auteur->getPrenom() . ' ' . $auteur->getNom();
                },
                'label' => 'Auteurs',
                'multiple' => true,
                'expanded' => true, // Affiche sous forme de cases à cocher
                'mapped' => false, // Ne pas lier ce champ à l'entité Document
                'attr' => ['class' => 'space-y-2'],
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
                'label' => 'Durée',
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