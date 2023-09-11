<?php
/**
 * Tea fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Tea;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class TeaFixtures.
 */
class TeaFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'teas', function (int $i) {
            /** @var Tea $tea */
            $tea = new Tea();

            /* Setting name for the tea */
            $tea->setTitle($this->faker->sentence);

            /* Setting time of creation and last update */
            $tea->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $tea->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            /**
             * Assigning random category to Tea object.
             *
             * @var Category $category
             */
            $category = $this->getRandomReference('categories');
            $tea->setCategory($category);

            /**
             * Assigning random tags to Tea object.
             *
             * @var array<array-key, Tag> $tags
             */
            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );
            foreach ($tags as $tag) {
                $tea->addTag($tag);
            }

            /**
             * Assigning random user as author.
             *
             * @var User $author
             */
            $author = $this->getRandomReference('users');
            $tea->setAuthor($author);

            /* Creating fake description for tea. */
            $tea->setDescription($this->faker->paragraph);

            /**
             *
             * Ingredients list randomly picked from Array
             * @var string[] $ingredientsArray
             */
            $ingredientsArray = ['black tea', 'white tea', 'green tea'];

            $tea->setIngredients(implode(', ',
                $this->faker->randomElements(
                    $ingredientsArray,
                    2
                ),
            ));

            /**
             * Steep temperature randomly picked from Array.
             *
             * @var int[] $steepTempArray
             */
            $steepTempArray = [70, 75, 80, 85, 90, 95];
            $tea->setSteepTemp($this->faker->randomElement($steepTempArray));

            /**
             * Steep time randomly picked from Array.
             *
             * @var int[] $steepTimeArray
             */
            $steepTimeArray = [1, 2, 3, 5, 10];
            $tea->setSteepTime($this->faker->randomElement($steepTimeArray));

            /**
             * Region name randomly picked from Array.
             *
             * @var string[] $regionArray
             */
            $regionArray = ['Yunnan'];
            $tea->setRegion($this->faker->randomElement($regionArray));

            /**
             * Vendor name randomly picked from Array.
             *
             * @var string[] $vendorArray
             */
            $vendorArray = ['e-herbata.pl'];
            $tea->setVendor($this->faker->randomElement($vendorArray));

            return $tea;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class, 1: TagFixtures::class, 2: UserFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class, TagFixtures::class, UserFixtures::class];
    }
}
