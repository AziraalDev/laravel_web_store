<?php

namespace App\Repositories\Contract;

use Illuminate\Database\Eloquent\Model;

interface ImagesRepositoryContract
{
    public function attach(Model $model, // unknown which one exactly
                           string $relation, //method
                           array $images = [],
                           ?string $directory = null): void;
}
