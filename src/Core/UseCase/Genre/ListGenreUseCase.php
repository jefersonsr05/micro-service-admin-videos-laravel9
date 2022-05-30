<?php

namespace Core\UseCase\Genre;

use Core\Domain\Repository\GenreRepositoryInterface;
use Core\UseCase\DTO\Genre\GenreInputDto;
use Core\UseCase\DTO\Genre\GenreOutputDto;

class ListGenreUseCase
{
    public function __construct(GenreRepositoryInterface $repository) 
    {
         $this->repository = $repository;
    }

    public function execute(GenreInputDto $input): GenreOutputDto
    {
        $genre = $this->repository->findById(genreId: $input->id);
        
        return new GenreOutputDto(
            name: $genre->name,
            id: (string) $genre->id,
            is_active: $genre->isActive,
            created_at: $genre->createdAt(),
        );
    }

}