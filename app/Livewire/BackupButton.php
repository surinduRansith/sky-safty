<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;


class BackupButton extends Component
{
    public  $backupMessage = '';

    public function runBackup()
    {
        $exitCode = Artisan::call('backup:run');
        $output   = Artisan::output();

        if ($exitCode === 0) {
            $this->backupMessage = "✅ Backup completed successfully!";
        } else {
            $this->backupMessage = "❌ Backup failed: " . $output;
        }
    }
    public function render()
    {
        return view('livewire.backup-button');
    }
}
