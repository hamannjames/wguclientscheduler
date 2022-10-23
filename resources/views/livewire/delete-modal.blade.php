<div class="fixed w-full min-h-screen max-w-full top-0 left-0 z-50 bg-opacity-75 bg-black flex items-center justify-center {{$show ? 'flex' : 'hidden'}}">
   <div class="p-8 bg-white rounded-xl text-center space-y-4">
        <h3 class="text-xl text-bold">Are you sure?</h3>
        <p>Are you sure you want to delete {{$class}} {{$modelId}}</p>
        @if (isset($message)) 
            <p>{{$message}}</p>
        @endif
        <div class="flex justify-center gap-2">
            <button class="btn btn-red" wire:click="cancel">Cancel</button>
            <button class="btn btn-green" wire:click="delete">Yes</button>
        </div>
   </div>
</div>
