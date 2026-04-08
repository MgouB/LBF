<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
                'fw-bold']])
            ->add('Nom', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
                'fw-bold']])
            ->add('Prenom', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
                'fw-bold']])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'data' => false,
                'label' => "Accepter les conditions générales d'utilisations",
                'label_attr' => ['class' => 'me-1 fw-bold'],
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez accepter les conditions d'utilisations",
                    ]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                    'autocomplete' => 'street-address',
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => [
                    'class' => 'form-control',
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
            ->add('Telephone', TelType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'ex: 06 12 34 56 78 ou +33...',
                    'autocomplete' => 'tel',
                ],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => true,
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
            ])

            ->add('plainPassword2', PasswordType::class, [
                'mapped' => true,
                'label_attr' => ['class' => 'fw-bold'],
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
            ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
