<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Carbon\Carbon;
use Auth;

class LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Logging logout event
        $user = Auth::user();
        $updated_at = Carbon::now()->toDateTimeString();
        $properties = [
            'attributes' =>
            [
            'name' => $user->name,
            'description' => 'Logout from system at '.$updated_at
            ]
        ];
        $desc = 'User '.$user->name.' logged out from the system';
        activity('auth')
        ->performedOn($user)
        ->causedBy($user)
        ->withProperties($properties)
        ->log($desc);
    }
}
