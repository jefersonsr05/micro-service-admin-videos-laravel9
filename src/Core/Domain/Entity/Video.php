<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Enum\Rating;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Video
{
    use MethodsMagicsTrait;
    protected array $categoriesId = [];
    protected array $genresId = [];
    protected array $castMembersId = [];

    public function __construct(
        protected string $title,
        protected string $description,
        protected int $yearLaunched,
        protected int $duration,
        protected bool $opened,
        protected Rating $rating,
        protected ?Uuid $id = null,
        protected bool $published = false,
        protected ?DateTime $createdAt = null,

    )
    {
        $this->id = $this->id ?? Uuid::random();
        $this->createdAt = $this->createdAt ?? new DateTime();
    }

    public function addCategoryId(string $categoryId)
    {
        array_push($this->categoriesId, $categoryId);
    }

    public function removeCategoryId(string $categoryId)
    {
        unset($this->categoriesId[array_search($categoryId, $this->categoriesId)]);

    }

    public function addGenre(string $genreId)
    {
        array_push($this->genresId, $genreId);
    }

    public function removeGenreId(string $genreId)
    {
        unset($this->genresId[array_search($genreId, $this->genresId)]);

    }

    public function addCastMember(string $castMemberId)
    {
        array_push($this->castMembersId, $castMemberId);
    }

    public function removeCastMemberId(string $castMemberId)
    {
        unset($this->castMembersId[array_search($castMemberId, $this->castMembersId)]);

    }

}
