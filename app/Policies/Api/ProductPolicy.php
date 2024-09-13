<?php

namespace App\Policies\Api;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->tokenCan('read') || $user->tokenCan('full');
    }

    public function view(User $user, Product $product): bool
    {
        return $user->tokenCan('read') || $user->tokenCan('full');
    }

    public function create(User $user): bool // Create Store
    {
        return $user->tokenCan('full');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->tokenCan('full');
    }
}
