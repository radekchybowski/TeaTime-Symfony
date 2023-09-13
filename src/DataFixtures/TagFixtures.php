<?php
/**
 * Tag Fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tag;

/**
 * Class TagFixtures.
 */
class TagFixtures extends AbstractBaseFixtures
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

        $this->createMany(100, 'tags', function () {
            $tag = new Tag();
            $tag->setTitle($this->faker->word);
            $tag->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days',
                        '-1 days'
                    )
                )
            );
            $tag->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days',
                        '-1 days'
                    )
                )
            );

            return $tag;
        });

        $this->manager->flush();
    }
}
