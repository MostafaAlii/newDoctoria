<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OtpCode;
use App\Jobs\UpdateOtpStatus;
use Illuminate\Support\Facades\Artisan;

class UpdateOtpStatusCommand extends Command
{
    protected $signature = 'otp:update-status';
    protected $description = 'Update otp status to Invalid after 1 hour';
    public function handle()
    {
        $otpCodes = OtpCode::where('status', 'valid')
            ->where('expires_at', '<=', now())
            ->get();
        foreach ($otpCodes as $otpCode) {
            UpdateOtpStatus::dispatch($otpCode->id);
        }
        $this->info('OTP statuses updated.');
        Artisan::call('queue:work', [
            '--queue' => 'default',
            '--tries' => 3,
        ]);
        $this->info('Queue worker started.');
    }
}
