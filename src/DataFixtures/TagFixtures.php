<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use App\DataFixtures\AbstractBaseFixtures;

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

        $this->createMany(100, 'tags', function (int $i) {
            $tag = new Tag();
            $tag->setTitle($this->faker->sentence);
            $tag->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days', '-1 days'
                    )
                )
            );
            $tag->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days', '-1 days'
                    )
                )
            );

            return $tag;
        });
    }
}