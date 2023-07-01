<?php
/**
 * Ad fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Ad;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class AdFixtures.
 */
class AdFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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

        $this->createMany(100, 'ads', function (int $i) {
            $ad = new Ad();
            $ad->setTitle($this->faker->sentence);
            $ad->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $ad->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $ad->setApproved(
                true
            );
            $ad->setContent(
                $this->faker->text(100)
            );
            $ad->setEmail(
                $this->faker->email()
            );
            /** @var Category $category */
            $category = $this->getRandomReference('categories');
            $ad->setCategory($category);

            return $ad;
        });

        $this->manager->flush();
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
