<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class UpdateCourseStudentStatistics
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $params;
    public $old_params;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($params,$old_params=null)
    {
       //return 
       $this->params=$params;
       $this->old_params=$old_params;
        //Log::info("the event constructor  is running\n");
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {       
        return new PrivateChannel('channel-name');
    }
}
