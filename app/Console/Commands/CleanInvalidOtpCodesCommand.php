<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Jobs\CleanInvalidOtpCodes;
use Illuminate\Support\Facades\Artisan;
class CleanInvalidOtpCodesCommand extends Command {
    protected $signature = 'otp:clean-invalid-code';
    protected $description = 'Clean invalid OTP codes from the database';
    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        CleanInvalidOtpCodes::dispatch();
        $this->info('Invalid OTP codes cleaned.');
        Artisan::call('queue:work', [
            '--queue' => 'default',
            '--tries' => 3,
        ]);
        $this->info('Queue worker started.');
    }
}
