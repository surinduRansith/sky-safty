<div >
    <div class="flex justify-center ">
        <button wire:click="runBackup"  class="btn btn-success">
            Run Backup
            <span class="loading loading-spinner text-warning" wire:loading></span>
        </button>
    </div>

<div class="mt-4">
    @if ($backupMessage)
    <div role="alert" class="alert {{$alert}} mb-4 max-w-md pt-5" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)"
        x-show="show">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span> {{ $backupMessage }}</span>
    </div>
@endif
</div>
    
</div>
