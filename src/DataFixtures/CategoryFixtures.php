<?php
/**
 * Category fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;

/**
 * Class CategoryFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class CategoryFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(18, 'categories', function () {
            $category = new Category();
            /*
             * Assigning title name of Category.
             */
            $categoryTitleArray = ['klasyczna', 'premium', 'zielona herbata', 'matcha', 'zielona z dodatkami', 'czarna herbata', 'czarna z dodatkami', 'oolong', 'pu-erh i heicha', 'pu-erh z dodatkami', 'biała herbata', 'biała z dodatkami', 'żółta herbata', 'owocowa', 'rooibos', 'yerba mate', 'zestawy herbat', 'zioła'];
            $category->setTitle($this->faker->unique()->randomElement($categoryTitleArray));

            /*
             * Assigning creation and last update time.
             */
            $category->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $category->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );

            return $category;
        });

        $this->manager->flush();
    }
}
