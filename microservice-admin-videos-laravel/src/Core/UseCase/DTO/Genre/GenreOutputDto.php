<?php

namespace Core\UseCase\DTO\Genre;

class GenreOutputDto
{
    public function __construct(
        public string $name,
        public string $id,
        public bool $is_active = true,
        public string $created_at = '',
    ) {}
}