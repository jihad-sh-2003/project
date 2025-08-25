<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportPolicy
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
    public function view(User $user, Report $report): bool
    {
       return $user->id === $report->user_id ;
    }

    /**
     * Determine whether the user can create models.
  
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Report $report): bool
    {
         return $user->id === $report->user_id;
    }


}
