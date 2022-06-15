<?php

namespace Tests\Feature\Core\UseCase\Genre;

use App\Models\Genre as Model;
use App\Repositories\Eloquent\GenreEloquentRepository;
use Core\UseCase\DTO\Genre\List\ListGenresInputDto;
use Core\UseCase\Genre\ListGenresUseCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListGenresUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFindAll()
    {
        $useCase = new ListGenresUseCase(
            new GenreEloquentRepository(new Model())
        );

        $genre = Model::factory()->count(100)->create();
        $responseUseCase = $useCase->execute(
            new ListGenresInputDto()
        );

        $this->assertEquals(15, count($responseUseCase->items));
        $this->assertEquals(100, $responseUseCase->total);
    }
}
