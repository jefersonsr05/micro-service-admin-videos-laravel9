<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Genre;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Uuid;
use DateTime;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class GenreUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testAttributes()
    {
        $uuid = (string) RamseyUuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');
        $genre = new Genre(
            id: new Uuid($uuid),
            name: 'New Genre',
            isActive: true,
            createdAt: new DateTime($date),
        );

        $this->assertEquals($uuid, $genre->id);
        $this->assertEquals('New Genre', $genre->name);
        $this->assertEquals(true, $genre->isActive);
        $this->assertEquals($date, $genre->createdAt());
    }

    public function testAttributesCreate()
    {
        $genre = new Genre(
            name: 'New Genre',
        );

        $this->assertNotEmpty($genre->id());
        $this->assertEquals('New Genre', $genre->name);
        $this->assertEquals(true, $genre->isActive);
        $this->assertNotEmpty($genre->createdAt());
    }

    public function testDeactivate()
    {
        $genre = new Genre(
            name: 'New Genre',
        );

        $this->assertTrue($genre->isActive);

        $genre->deactivate();
        $this->assertFalse($genre->isActive);
    }

    public function testActivate()
    {
        $genre = new Genre(
            name: 'New Genre',
            isActive: false,
        );

        $this->assertFalse($genre->isActive);
      
        $genre->activate();
        $this->assertTrue($genre->isActive);
    }

    public function testUpdate()
    {
        $genre = new Genre(
            name: 'teste'
        );
        $this->assertEquals('teste', $genre->name);

        $genre->update(
            name: 'Name Updated'
        );
        $this->assertEquals('Name Updated', $genre->name);
    }

    public function testEntityExceptions()
    {
        $this->expectException(EntityValidationException::class);

        $genre = new Genre(
            name: 's',
        );
    }

    public function testEntityUpdateExceptions()
    {
        $this->expectException(EntityValidationException::class);
        
        $uuid = (string) RamseyUuid::uuid4()->toString();
        $date = date('Y-m-d H:i:s');
        $genre = new Genre(
            id: new Uuid($uuid),
            name: 'New Genre',
            isActive: false,
            createdAt: new DateTime($date),
        );

        $genre->update(
            name: 's'
        );
    }

    public function testAddCategoryToGenre()
    {
        $categoryId = (string) RamseyUuid::uuid4()->toString();
        $genre = new Genre(
            name: 'New Genre'
        );

        $this->assertIsArray($genre->categoriesId);
        $this->assertCount(0, $genre->categoriesId);

        $genre->addCategory(
            categoryId: $categoryId
        );
        $genre->addCategory(
            categoryId: $categoryId
        );
        $genre->addCategory(
            categoryId: $categoryId
        );
        $this->assertCount(3, $genre->categoriesId);

    }

    public function testRemoveCategoryToGenre()
    {
        $categoryId = (string) RamseyUuid::uuid4()->toString();
        $categoryId2 = (string) RamseyUuid::uuid4()->toString();
        $genre = new Genre(
            name: 'New Genre',
            categoriesId: [
                $categoryId,
                $categoryId2,
            ]
        );

        $this->assertCount(2, $genre->categoriesId);
        $genre->removeCategory(categoryId: $categoryId);
        $this->assertCount(1, $genre->categoriesId);
        $this->assertEquals($categoryId2, $genre->categoriesId[1]);

    }

}
