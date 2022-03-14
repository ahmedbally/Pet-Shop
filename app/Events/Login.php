<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Login
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var  Authenticatable|null user
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param Authenticatable|null $user
     * @return void
     */
    public function __construct(?Authenticatable $user)
    {
        $this->user = $user;
    }
}
