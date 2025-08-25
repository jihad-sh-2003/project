<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PropertyPolicy
{
        /**
     * Determine whether the user can view any models.
     */
    public function before(User $user,string $ability):bool|null
    {

        if ($user->hasRole('admin' )||$user->hasRole('super_admin' )) {
            return true;    
        }
        return null;          
    }

   

    /**
     * Determine whether the user can view the model.
     */
    public function viewAny(User $user, Property $property): bool
    {
        return $user->id===$property->user_id;
    }
    

 
    public function update(User $user, Property $property): bool
    {
        return $user->id===$property->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Property $property): bool
    {
        return $user->id===$property->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function approve(User $user, Property $property): bool
    {

        return $user->can('approve');
    }

    public function changestatus(User $user, Property $property): bool
    {
        return $user->can('changestatus');
    }
   
}
