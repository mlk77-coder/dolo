<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\Customer;
use Illuminate\Auth\Access\Response;

class AdvertisementPolicy
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
    public function view(Customer $customer, Advertisement $advertisement): bool
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
    public function update(Customer $customer, Advertisement $advertisement): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Customer $customer, Advertisement $advertisement): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Customer $customer, Advertisement $advertisement): bool
    {
        return $customer->is_admin ?? false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Customer $customer, Advertisement $advertisement): bool
    {
        return $customer->is_admin ?? false;
    }
}
