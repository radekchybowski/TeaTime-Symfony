<?php
/**
 * Form for registration.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationFormType.
 */
class RegistrationFormType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'invalid_message' => 'message.invalid_email',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'message.please_enter_password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'message.password_limit',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'type' => PasswordType::class,
                'invalid_message' => 'message.password_match',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'label.name',
                    'required' => false,
                    'attr' => ['max_length' => 64, 'class' => 'form-control'],
                    'label_attr' => ['class' => 'form-label'],
                ]
            )
            ->add(
                'surname',
                TextType::class,
                [
                    'label' => 'label.surname',
                    'required' => false,
                    'attr' => ['max_length' => 64, 'class' => 'form-control'],
                    'label_attr' => ['class' => 'form-label'],
                ]
            );
    }

    /**
     * Configuration.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'allow_extra_fields' => true,
        ]);
    }
}
