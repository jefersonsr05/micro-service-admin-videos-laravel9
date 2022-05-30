<?php

namespace App\Repositories\Eloquent;

use App\Models\Genre as Model;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Genre as Entity;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\Domain\ValueObject\Uuid;
use DateTime;
use Spatie\FlareClient\Http\Exceptions\NotFound;

use function PHPUnit\Framework\throwException;

class GenreEloquentRepository implements GenreRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function insert(Entity $genre): Entity
    {
        $genreDb = $this->model->create([
            'id' => $genre->id(),
            'name' => $genre->name,
            'is_active' => $genre->isActive,
            'created_at' => $genre->createdAt(),
        ]);

        if (count($genre->categoriesId) > 0) {
            $genreDb->categories()->sync($genre->categoriesId);
        }

        return $this->toGenre($genreDb);
    }
    public function findById(string $genreId): Entity
    {
        if (!$genreDb = $this->model->find($genreId)) {
            throw new NotFoundException("Genre {$genreId} not found");            
        }

        return $this->toGenre($genreDb);
    }
    public function getIdsListIds(array $categoriesId = []): array
    {

    }
    public function findAll(string $filter = '', $order = 'DESC'): array
    {

    }
    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface
    {

    }
    public function update(Entity $genre): Entity
    {

    }
    public function delete(string $genreId): bool
    {
        
    }

    private function toGenre(Model $object): Entity
    {
        $entity = new Entity(
            id: new Uuid($object->id),
            name: $object->name,
            createdAt: new DateTime($object->created_at),
        );

        ((bool) $object->is_active) ? $entity->activate() : $entity->deactivate();

        return $entity;
    }
}