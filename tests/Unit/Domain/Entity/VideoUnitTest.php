<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Video;
use Core\Domain\Enum\Rating;
use Core\Domain\ValueObject\Uuid;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RanseyUuid;

class VideoUnitTest extends TestCase
{
    public function testAttributes()
    {
        $uuid = (string) RanseyUuid::uuid4();
        $entity = new Video(
            id: new Uuid($uuid),
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            published: true,
            rating: Rating::RATE12,
            createdAt: new DateTime(date('Y-m-d H:i:s')),
        );

        $this->assertEquals($uuid, $entity->id());
        $this->assertEquals('new title', $entity->title);
        $this->assertEquals('test description', $entity->description);
        $this->assertEquals(2029, $entity->yearLaunched);
        $this->assertEquals(12, $entity->duration);
        $this->assertEquals(true, $entity->opened);
        $this->assertEquals(true, $entity->published);
        $this->assertEquals(Rating::RATE12, $entity->rating);
        $this->assertNotNull($entity->createdAt());

    }

    public function testIdAndCreatedAt()
    {
        $entity = new Video(
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $this->assertNotEmpty($entity->id());
        $this->assertNotEmpty($entity->createdAt());
        $this->assertEquals(false, $entity->published);

    }

    public function testAddCategoryId()
    {

        $entity = new Video(
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $categoryUuid = (string) RanseyUuid::uuid4();

        $this->assertCount(0, $entity->categoriesId);
        $entity->addCategoryId(
            categoryId: $categoryUuid,
        );
        $entity->addCategoryId(
            categoryId: $categoryUuid,
        );

        $this->assertCount(2, $entity->categoriesId);
    }

    public function testRemoveCategoryId()
    {

        $entity = new Video(
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $categoryUuid = (string) RanseyUuid::uuid4();

        $entity->addCategoryId(
            categoryId: $categoryUuid,
        );
        $this->assertCount(1, $entity->categoriesId);

        $entity->removeCategoryId(
            categoryId: $categoryUuid,
        );
        $this->assertCount(0, $entity->categoriesId);
    }

    public function testAddGenreId()
    {

        $entity = new Video(
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $genreUuid = (string) RanseyUuid::uuid4();

        $this->assertCount(0, $entity->genresId);
        $entity->addGenre(
            genreId: $genreUuid,
        );
        $entity->addGenre(
            genreId: $genreUuid,
        );

        $this->assertCount(2, $entity->genresId);
    }

    public function testRemoveGenreId()
    {

        $entity = new Video(
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $genreUuid = (string) RanseyUuid::uuid4();

        $entity->addGenre(
            genreId: $genreUuid,
        );
        $this->assertCount(1, $entity->genresId);

        $entity->removeGenreId(
            genreId: $genreUuid,
        );
        $this->assertCount(0, $entity->genresId);
    }

    public function testAddCastMemberId()
    {

        $entity = new Video(
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $castMemberUuid = (string) RanseyUuid::uuid4();

        $this->assertCount(0, $entity->castMembersId);
        $entity->addCastMember(
            castMemberId: $castMemberUuid,
        );
        $entity->addCastMember(
            castMemberId: $castMemberUuid,
        );

        $this->assertCount(2, $entity->castMembersId);
    }

    public function testRemoveCastMemberId()
    {

        $entity = new Video(
            title: 'new title',
            description: 'test description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $castMemberUuid = (string) RanseyUuid::uuid4();

        $entity->addCastMember(
            castMemberId: $castMemberUuid,
        );
        $this->assertCount(1, $entity->castMembersId);

        $entity->removeCastMemberId(
            castMemberId: $castMemberUuid,
        );
        $this->assertCount(0, $entity->castMembersId);
    }

}
