<div>
    @if(isset($modelId)) 
        <button class="btn btn-red" wire:click="$emit('modelWillBeDeleted', {
            class: '{{$modelClass}}', 
            id: {{$modelId}},
            message: '{{$message ?? ''}}'
        })">Delete</button>
    @endif
</div>
