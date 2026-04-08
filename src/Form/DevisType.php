<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom / Prénom ',
            'required' => true,
            'attr' => ['class' => 'form-control'],
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email ',
            'required' => true,
            'attr' => ['class' => 'form-control'],
        ])
        ->add('telephone', TelType::class, [
            'label' => 'Téléphone ',
            'required' => true,
            'attr' => ['class' => 'form-control'],
        ])
        ->add('service', ChoiceType::class, [
            'label' => 'Type de prestation souhaitée ',
            'required' => true,
            'placeholder' => '-- Sélectionnez --',
            'choices' => [
                'Espace vert / Élagage' => 'elagage',
                'Abattage' => 'abattage',
                'Entretien' => 'entretien',
                'Autre' => 'autre',
            ],
            'attr' => ['class' => 'form-select'],
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Votre message / précisions',
            'required' => false,
            'attr' => [
                'class' => 'form-control',
                'rows' => 5,
            ],
        ])
        ->add('envoyer', SubmitType::class, [
            'label' => 'Envoyer ma demande',
            'attr' => ['class' => 'btn btn-success px-5 py-2 fw-bold mt-3'],
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
