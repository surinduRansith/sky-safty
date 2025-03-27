<div>

        <button wire:click="runBackup" class="btn btn-primary">Run Backup</button>
        
        @if (session()->has('message'))
            <div class="alert alert-success mt-2">
                {{ session('message') }}
            </div>
        @endif

    
</div>
