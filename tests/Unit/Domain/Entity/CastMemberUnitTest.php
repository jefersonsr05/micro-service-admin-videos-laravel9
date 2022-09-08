<?php

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Core\Domain\Entity\CastMember;
use Core\Domain\ValueObject\Uuid;
use DateTime;
use Core\Domain\Enum\CastMemberType;
use Core\Domain\Exception\EntityValidationException;
use Ramsey\Uuid\Uuid as RamseyUuid;

use function PHPSTORM_META\type;

class CastMemberUnitTest extends TestCase
{
    public function testAttributes()
    {
        $uuid = (string) RamseyUuid::uuid4();

        $castMember = new CastMember
        (
            id: new Uuid($uuid),
            name: 'Name',
            type: CastMemberType::ACTOR,
            createdAt: new DateTime(date('Y-m-d H:i:s'))
        );

        $this->assertEquals($uuid, $castMember->id());
        $this->assertEquals('Name', $castMember->name);
        $this->assertEquals(CastMemberType::ACTOR, $castMember->type);
        $this->assertNotEmpty($castMember->createdAt());

    }

    public function testAttributesNewEntity()
    {
        $castMember = new CastMember
        (
            name: 'Name',
            type: CastMemberType::DIRECTOR,
        );

        $this->assertNotEmpty($castMember->id());
        $this->assertEquals('Name', $castMember->name);
        $this->assertEquals(CastMemberType::DIRECTOR, $castMember->type);
        $this->assertNotEmpty($castMember->createdAt());

    }

    public function testValidation()
    {
        $this->expectException(EntityValidationException::class);
        new CastMember(
            name: 'AP',
            type: CastMemberType::DIRECTOR,
        );
    }

    public function testExceptionUpdate()
    {
        $this->expectException(EntityValidationException::class);
        $castMember = new CastMember(
            name: 'AP',
            type: CastMemberType::DIRECTOR,
        );

        $castMember->update(
            name: 'new name',
        );

        $this->assertEquals('New name', $castMember->name);
    }

    public function testUpdate()
    {
        $castMember = new CastMember(
            name: 'correct name',
            type: CastMemberType::DIRECTOR,
        );
        $this->assertEquals('correct name', $castMember->name);

        $castMember->update(
            name: 'new name',
        );

        $this->assertEquals('new name', $castMember->name);
    }


}
