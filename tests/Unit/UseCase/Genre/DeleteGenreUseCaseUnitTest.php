<?php

namespace Tests\Unit\UseCase\Genre;

use Core\UseCase\DTO\Genre\GenreInputDto;
use Core\UseCase\DTO\Genre\Delete\DeleteGenreOutputDto;
use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\UseCase\Genre\DeleteGenreUseCase;
use Mockery;
use PhpParser\Node\Expr\New_;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteGenreUseCaseUnitTest extends TestCase
{
    public function test_delete()
    {

        $uuid = (string) RamseyUuid::uuid4();

        //arrange
        $mockRepository = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        //expect
        $mockRepository->shouldReceive('delete')
                                        ->once() //testa se chamou apenas uma vez
                                        ->with($uuid)
                                        ->andReturn(true);

        $mockInputDto = Mockery::mock(GenreInputDto::class, [$uuid]);

        $useCase = new DeleteGenreUseCase($mockRepository);

        //action
        $response = $useCase->execute($mockInputDto);

        //assert
        $this->assertInstanceOf(DeleteGenreOutputDto::class, $response);
        $this->assertTrue($response->success);
    }

    public function test_delete_false()
    {

        $uuid = (string) RamseyUuid::uuid4();

        $mockRepository = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('delete')
                                        ->once() //testa se chamou apenas uma vez
                                        ->with($uuid)
                                        ->andReturn(false);

        $mockInputDto = Mockery::mock(GenreInputDto::class, [$uuid]);

        $useCase = new DeleteGenreUseCase($mockRepository);
        $response = $useCase->execute($mockInputDto);

        $this->assertFalse($response->success);
    }

    protected function tearDown():void
    {
        Mockery::close();
        parent::tearDown();
    }

}
