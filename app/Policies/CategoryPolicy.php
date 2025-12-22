<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Customer;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Customer $customer): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Customer $customer, Category $category): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Customer $customer): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Customer $customer, Category $category): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Customer $customer, Category $category): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Customer $customer, Category $category): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Customer $customer, Category $category): bool
    {
        return $customer->is_admin ?? false;
    }
}
