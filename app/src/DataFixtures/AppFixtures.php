<?php
/**
 * License Block.
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Default App Fixtures.
 */
class AppFixtures extends Fixture
{
    /** Load.
     * @param ObjectManager $manager Object Manager
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
