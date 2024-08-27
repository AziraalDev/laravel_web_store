<?php

namespace App\Listeners\Orders;

use App\Enums\Role;
use App\Events\OrderCreatedEvent;
use App\Models\User;
use App\Notifications\Admin\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class CreatedListener implements ShouldQueue
{

    public function __construct()
    {
        //
    }

    public function viaQueue(): string
    {
        return 'listeners';
    }

    public function handle(OrderCreatedEvent $event): void
    {
        logs()->info('CreatedListener::handle');
        Notification::send(
            User::role(Role::ADMIN->value)->get(), // Getting users
            app(OrderCreatedNotification::class, ['order' => $event->order])
        );
    }
}
