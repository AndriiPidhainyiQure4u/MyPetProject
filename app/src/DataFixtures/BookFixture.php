<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class BookFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $androidCategory = $this->getReference(BoolCategoryFixtures::ANDROID_CATEGORY);
        $devicesCategory = $this->getReference(BoolCategoryFixtures::DEVICES_CATEGORY);

        $book = (new Book())
            ->setTitle('RxJava for Android Developers')
            ->setPublicationDate(new \DateTimeImmutable('2019-04-01'))
            ->setIsbn('123321')
            ->setDescription('test description')
            ->setMeap(false)
            ->setAuthors(['Timo Tuominen'])
            ->setSlug('rxjava-for-android-developers')
            ->setCategories(new ArrayCollection([$androidCategory, $devicesCategory]))
            ->setImage(
                'https://images.manning.com/360/480/resize/book/b/bc57fb7-b239-4bf5-bbf2-886be8936951/Tuominen-RxJava-HI.png'
            );

        $manager->persist($book);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BoolCategoryFixtures::class,
        ];
    }
}
