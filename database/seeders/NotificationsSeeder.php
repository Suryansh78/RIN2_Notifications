<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class NotificationsSeeder extends Seeder
{
    public function run()
    {
        $users = User::take(3)->pluck('id')->toArray();

        Notification::create([
            'type' => 'system',
            'short_text' => 'System maintenance scheduled',
            'body' => 'Full maintenance on Sunday 02:00-04:00 UTC.',
            'expires_at' => Carbon::now()->addDays(7),
            'destination_user_id' => null, // all users
        ]);

        Notification::create([
            'type' => 'marketing',
            'short_text' => 'Special offer for you',
            'body' => 'Get 25% off this month',
            'expires_at' => Carbon::now()->addDays(14),
            'destination_user_id' => $users[0] ?? null,
        ]);

        Notification::create([
            'type' => 'invoices',
            'short_text' => 'Invoice due',
            'body' => 'Your invoice #123 is due in 5 days.',
            'expires_at' => Carbon::now()->addDays(5),
            'destination_user_id' => $users[1] ?? null,
        ]);
    }
}
