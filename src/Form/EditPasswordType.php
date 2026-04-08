<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'mapped' => false,
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('plainPassword2', PasswordType::class, [
                'label' => 'Confirmez le nouveau mot de passe',
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('modify', SubmitType::class, [
                'attr' => ['class' => 'btn bg-primary text-white m-4'],
                'row_attr' => ['class' => 'text-center'],
                'label' => 'Modifier', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Classe du modèle
        ]);
    }
}
