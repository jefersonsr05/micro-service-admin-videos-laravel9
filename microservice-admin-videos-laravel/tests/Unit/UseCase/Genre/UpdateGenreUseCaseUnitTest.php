<?php

namespace Tests\Unit\UseCase\Genre;

use Core\UseCase\DTO\Genre\Update\{
    GenreUpdateInputDto,
    GenreUpdateOutputDto,
};
use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Core\UseCase\Genre\UpdateGenreUseCase;
use Core\UseCase\Interfaces\TransactionInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateGenreUseCaseUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_update()
    {
        $uuid = (string) Uuid::uuid4();        

        $useCase = new UpdateGenreUseCase($this->mockRepository($uuid), $this->mockTransaction(), $this->mockCategoryRepository($uuid));
        $response = $useCase->execute($this->mockUpdateInputDto($uuid, [$uuid] ));

        $this->assertInstanceOf(GenreUpdateOutputDto::class, $response);
    }

    public function test_update_categories_notfound()
    {
        $this->expectException(NotFoundException::class);
        
        $uuid = (string) Uuid::uuid4();      

        $useCase = new UpdateGenreUseCase($this->mockRepository($uuid, 0), $this->mockTransaction(), $this->mockCategoryRepository($uuid));
        $response = $useCase->execute($this->mockUpdateInputDto($uuid, [$uuid, 'fake_id', 'fake_id_two']));        
    }

    private function mockEntity(string $uuid)
    {
        $mockEntity = Mockery::mock(EntityGenre::class, [
            'teste',
            new ValueObjectUuid($uuid),
            true,
            []
        ]);

        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));
        $mockEntity->shouldReceive('update')->once();
        $mockEntity->shouldReceive('addCategory');

        return $mockEntity;
    }

    private function mockRepository(string $uuid, int $timesCalled = 1)
    {
        $mockEntity = $this->mockEntity($uuid);
        $mockRepository = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')
                        ->once()
                        ->with($uuid)
                        ->andReturn($mockEntity);
        $mockRepository->shouldReceive('update')
                        ->times($timesCalled)
                        ->andReturn($mockEntity);

        return $mockRepository;
    }

    private function mockTransaction()
    {
        $mockTransaction = Mockery::mock(stdClass::class, TransactionInterface::class);
        $mockTransaction->shouldReceive('commit');
        $mockTransaction->shouldReceive('rollback');

        return $mockTransaction;
    }

    private function mockCategoryRepository(string $uuid)
    {
        $mockCategoryRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockCategoryRepository->shouldReceive('getIdsListIds')->once()->andReturn([$uuid]);

        return $mockCategoryRepository;
    }

    private function mockUpdateInputDto(string $uuid, array $categoriesIds = [])
    {
        return $mockUpdateInputDto = Mockery::mock(GenreUpdateInputDto::class, [
            $uuid, 'name to updated', $categoriesIds
        ]);

    }
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
