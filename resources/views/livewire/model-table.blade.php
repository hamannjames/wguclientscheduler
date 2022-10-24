<div>
    @if (isset($filters))
    <p class="text-right">If you have filtered the table, you need to refresh the page to delete {{$baseClass}}s.</p>
        <div class="flex justify-end items-center gap-4 flex-wrap">
        @foreach($filters as $filter)
            <x-dynamic-component :component="'filters.' . Str::kebab(class_basename($filter))" class="mb-2" />
        @endforeach
        </div>
    @endif
    <section class="grid overflow-x-scroll" style="grid-template-columns: repeat({{$filtered ? count($columns) : count($columns) + 1}}, auto);">
        @foreach($columns as $column)
            <div class="font-bold bg-gray-200 p-2">{{$column['display']}}</div>
        @endforeach
        @if(!$filtered)
        <div class="font-bold bg-gray-200 p-2"></div>
        @endif
    @forelse ($models as $model)
        @foreach ($columns as $key => $column)
            <div class="{{$loop->parent->index % 2 != 0 ? 'bg-gray-200' : ''}} p-2">
            @php
                $data = \App\Http\Livewire\ModelTable::travelProp($column, $model);
                $route = 'admin.' . Str::snake(class_basename(get_class($model)));
            @endphp
            @if($loop->first)
                <a href="{{route($route . '.show', $model)}}">
            @endif
            @switch($data['type'])
                @case('method')
                @case('property')
                    {{$data['value']}}
                    @break;
                @case('date')
                    @php
                        $th = \Services\Helpers\TimeHelper::get();
                    @endphp
                    {{$th->displayUserDateAndTime($data['value'])}}
                    @break
                @case('relationship')
                    {{$data['value']->toString()}}
                    @break;
                @case('route')
                    @if(isset($data['route']) && isset($data['value']))
                        <a href="{{route($data['route'], $data['value'])}}">{{$data['value']->toString()}}</a>
                    @endif
                    @break;
            @endswitch
            @if($loop->first)
                </a>
            @endif
            </div>
        @endforeach
        @if(!$filtered)
        <div class="{{$loop->index % 2 != 0 ? 'bg-gray-200' : ''}} p-2">
            @php
                $message;
                switch($baseClass) {
                    case('Customer'):
                    case('Appointment'):
                        $message = "All their appointments will also be deleted";
                        break;
                    default:
                        $message = '';
                }
            @endphp
            <button
                class="btn btn-red"
                wire:click="$emit('modelWillBeDeleted', {
                        class: '{{$baseClass}}', 
                        id: {{$model->id}},
                        message: '{{$message}}'
                })"
            >Delete</button>
        </div>
        @endif
    @empty
        <p>There are no items</p>
    @endforelse
    </section>
</section>
