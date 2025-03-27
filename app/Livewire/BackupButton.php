<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;


class BackupButton extends Component
{
    public function runBackup()
    {
        try {
            // Run the backup command
            $exitCode = Artisan::call('backup:run');
            //dd(Artisan::output());

            // Check if there was an error during the process
            $output = Artisan::output();
            if ($exitCode !== 0) {
                session()->flash('message', 'Backup failed: ' . $output);
            } else {
                session()->flash('message', 'Backup started!');
            }
        } catch (\Exception $e) {
            session()->flash('message', 'Backup error: ' . $e->getMessage());
        }
        
    }
    public function render()
    {
        return view('livewire.backup-button');
    }
}
