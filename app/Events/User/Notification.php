<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 29/02/16
 * Time: 10:13
 */

namespace App\Events\User;


use App\Events\Event;
use App\Models\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class Notification extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user = null;

    public $message = '';

    public $timeout = 3000;

    public function __construct(User $user, $message = '', $timeout = 3000){
        $this->user = $user;
        $this->message = $message;
        $this->timeout = $timeout;
    }

    public function broadcastOn()
    {
        return ['user.'.$this->user->email];
    }

}