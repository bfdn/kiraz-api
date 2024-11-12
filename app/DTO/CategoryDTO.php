<?php

namespace App\DTO;


class CategoryDTO
{
    public function __construct(
        public string $name,
        public string $slug,
        public ?int $parent_id = null,
    ) {}
}
