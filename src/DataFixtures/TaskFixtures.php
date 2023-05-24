<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Persistence\ObjectManager;
use Monolog\DateTimeImmutable;


class TaskFixtures extends AbstractBaseFixtures
{
    public function loadData(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $task = new Task();
            $task->setTitle($this->faker->sentence);
            $task->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days', '-1 days'
                    )
                )
            );
            $task->setUpdatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween(
                        '-100 days', '-1 days'
                    )
                )
            );
            $this->manager->persist($task);
        }

        $this->manager->flush();
    }
}
