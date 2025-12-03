<?php

namespace App\Console\Commands;

use App\Models\Master\Karyawan;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LinkExistingUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:link-existing-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Links existing user accounts to their corresponding employee records in m_karyawan based on email address.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to link existing users to employee records...');

        $usersToLink = User::whereNull('karyawan_id')->get();

        if ($usersToLink->isEmpty()) {
            $this->info('No users to link. All users already have an associated employee record.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($usersToLink->count());
        $progressBar->start();

        $linkedCount = 0;
        $notFoundCount = 0;

        foreach ($usersToLink as $user) {
            if (empty($user->email)) {
                $this->warn("\nSkipping user ID {$user->id} due to empty email.");
                $notFoundCount++;
                $progressBar->advance();
                continue;
            }

            // Find Karyawan with matching email.
            // Using DB facade for performance on potentially large datasets
            $karyawan = DB::connection('pgsql_master')
                ->table('m_karyawan')
                ->where('email', $user->email)
                ->first();

            if ($karyawan) {
                // Since we found a match, update the user.
                $user->karyawan_id = $karyawan->id;
                $user->save();
                $linkedCount++;
            } else {
                $this->warn("\nNo employee record found for user with email: {$user->email} (User ID: {$user->id})");
                $notFoundCount++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\n\nLinking process finished.");
        $this->info("Successfully linked: {$linkedCount} users.");
        $this->warn("Could not find a match for: {$notFoundCount} users.");

        return 0;
    }
}