<?php

namespace App\Events;

use App\Models\Admin;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class User
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $admin = null;

    protected $time = null;

    /**
     * UserLogin constructor.
     * @param $admin
     * @param $time
     */
    public function __construct($admin, $time)
    {
        //
        $this->admin = $admin;
        $this->time = $time;
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

    /**
     * 用户登入时候的操作
     */
    public function onLoginIn()
    {
        Log::info('进入处理队列');
        try {
            Admin::query()
                ->where([
                    'id' => $this->admin['id']
                ])
                ->update([
                    'last_login_time' => $this->time
                ]);
        }catch (\Exception $e) {
            Log::error('更新表错误'. $e->getMessage());
        }
    }

    /**
     * 用户登出时候的操作
     */
    public function onLoginOut()
    {
        Log::info('进入队列处理');
        try {
            Admin::query()
                ->where([
                    'id' => $this->admin['id']
                ])
                ->update([
                    'last_login_time' => $this->time
                ]);
        }catch (\Exception $e) {
            Log::error('更新表错误'. $e->getMessage());
        }
    }
}
