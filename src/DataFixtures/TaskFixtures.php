<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\DataFixtures\AbstractBaseFixtures;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends AbstractBaseFixtures
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

        $this->createMany(100, 'tasks', function (int $i) {
            $task = new Task();
            $task->setTitle($this->faker->sentence);
            $task->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days', '-1 days'
                    )
                )
            );
            $task->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days', '-1 days'
                    )
                )
            );

            $task->setComment(
                $this->faker->paragraph
            );

            /** @var Category $category */
            $category = $this->getRandomReference('categories');
            $task->setCategory($category);

            return $task;
        });

        $this->manager->flush();

        //        for ($i = 0; $i < 10; ++$i) {
        //            $task = new Task();
        //            $task->setTitle($this->faker->sentence);
        //            $task->setCreatedAt(
        //                \DateTimeImmutable::createFromMutable(
        //                    $this->faker->dateTimeBetween(
        //                        '-100 days', '-1 days'
        //                    )
        //                )
        //            );
        //            $task->setUpdatedAt(
        //                \DateTimeImmutable::createFromMutable(
        //                    $this->faker->dateTimeBetween(
        //                        '-100 days', '-1 days'
        //                    )
        //                )
        //            );
        //            $task->setComment(
        //                $this->faker->paragraph
        //            );
        //            $this->manager->persist($task);
        //        }
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
