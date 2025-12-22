<?php

namespace App\Policies;

use App\Models\MobileCarouselImage;
use App\Models\Customer;
use Illuminate\Auth\Access\Response;

class MobileCarouselImagePolicy
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
    public function view(Customer $customer, MobileCarouselImage $mobileCarouselImage): bool
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
    public function update(Customer $customer, MobileCarouselImage $mobileCarouselImage): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Customer $customer, MobileCarouselImage $mobileCarouselImage): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Customer $customer, MobileCarouselImage $mobileCarouselImage): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Customer $customer, MobileCarouselImage $mobileCarouselImage): bool
    {
        return $customer->is_admin ?? false;
    }
}
