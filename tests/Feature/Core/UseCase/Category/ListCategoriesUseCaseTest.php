<?php

namespace Tests\Feature\Core\UseCase\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_empty()
    {
        $responseUseCase = $this->createUseCase();

        $this->assertCount(0, $responseUseCase->items);
    }

    public function test_list_all()
    {
        $categoriesDb = Model::factory()->count(20)->create();

        $responseUseCase = $this->createUseCase();
        $this->assertCount(15, $responseUseCase->items); // 15 por causa da paginacao
        $this->assertEquals(count($categoriesDb), $responseUseCase->total);

    }

    private function createUseCase()
    {
        $repository = new CategoryEloquentRepository(new Model());
        $useCase = new ListCategoriesUseCase($repository);
        return $useCase->execute(new ListCategoriesInputDto());

    }

}
