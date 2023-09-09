<?php
/**
 * Comment type.
 */

namespace App\Form\Type;

use App\Entity\Comment;
use App\Entity\Tea;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

/**
 * Class CommentType.
 */
class CommentType extends AbstractType
{
    /**
     * Security helper.
     */
    private Security $security;

    /**
     * Constructor.
     *
     * @param Security $security Security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.comment.title',
                'required' => false,
                'attr' => ['max_length' => 255],
            ]);
        $builder->add(
            'content',
            TextareaType::class,
            [
                'label' => 'label.comment.content',
                'required' => true,
                'attr' => ['max_length' => 2048],
            ]
        );

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add(
                'tea',
                EntityType::class,
                [
                    'class' => Tea::class,
                    'choice_label' => function ($tea): string {
                        return $tea->getTitle();
                    },
                    'label' => 'label.tea.title',
                    'placeholder' => 'label.none',
                    'required' => true,
                ]
            );
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add(
                'author',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => function ($user): string {
                        return $user->getEmail();
                    },
                    'label' => 'label.comment.user.email',
                    'placeholder' => 'label.none',
                    'required' => true,
                ]
            );
        }
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Comment::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'comment';
    }
}
