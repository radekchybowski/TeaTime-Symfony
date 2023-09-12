<?php
/**
 * Tea type.
 */

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Tea;
use App\Entity\User;
use App\Form\DataTransformer\TagsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

/**
 * Class TeaType.
 */
class TeaType extends AbstractType
{
    /**
     * Tags data transformer.
     */
    private TagsDataTransformer $tagsDataTransformer;

    /**
     * Security helper.
     */
    private Security $security;

    /**
     * Constructor.
     *
     * @param TagsDataTransformer $tagsDataTransformer Tags data transformer
     * @param Security            $security            Security
     */
    public function __construct(TagsDataTransformer $tagsDataTransformer, Security $security)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
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
                'label' => 'label.title',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );
        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category): string {
                    return $category->getTitle();
                },
                'label' => 'label.category',
                'placeholder' => 'label.none',
                'required' => true,
            ]
        );
        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label.tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );
        $builder->add(
            'description',
            TextareaType::class,
            [
                'label' => 'label.description',
                'required' => false,
                'attr' => ['max_length' => 2048],
            ]
        );

        $builder->add(
            'region',
            TextType::class,
            [
                'label' => 'label.region',
                'required' => false,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->add(
            'vendor',
            TextType::class,
            [
                'label' => 'label.vendor',
                'required' => false,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->add(
            'steepTime',
            IntegerType::class,
            [
                'label' => 'label.steepTime',
                'required' => false,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->add(
            'steepTemp',
            IntegerType::class,
            [
                'label' => 'label.steepTemp',
                'required' => false,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );

        if ($this->security->isGranted('ROLE_ADMIN')) {
            $builder->add(
                'author',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => function ($user): string {
                        return $user->getEmail();
                    },
                    'label' => 'label.user.email',
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
        $resolver->setDefaults(['data_class' => Tea::class]);
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
        return 'tea';
    }
}
