<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;





class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Modérateur' => 'ROLE_MOD',
                    'User' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('Password', TextType::class, [
                'mapped' => true,
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
            ])
            ->add('Nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('Prenom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('adresse',TextType::class, [
                'label' => 'Adresse',
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'street-address',
                ],
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => 5,
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Activer' => 'Activer',
                    'Desactiver' => 'Desactiver',
                ],
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('Telephone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            
            ->add('Date_inscription', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('Modifier', SubmitType::class, [
                'attr' => ['class' => 'btn bg-primary text-white m-4'],
                'row_attr' => ['class' => 'text-center'],
                'label' => 'Modifier', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}