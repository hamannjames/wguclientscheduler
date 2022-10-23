<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Pipeline\Pipeline;

abstract class ModelTable extends Component
{
    public $models;
    public $columns;
    public $filters;
    private $query;
    public $baseClass;
    public $filtered;

    protected function getListeners() {
        return ['model' . $this->baseClass . 'MustBeDeleted' => 'delete'];
    }

    protected function onMount($columns = null, $filters = null) {
        $this->baseClass = class_basename($this->baseModel);
        $this->columns = $columns;
        $this->filters = $filters;
        $this->filtered = false;
    }

    protected $rules = [
        'search' => 'min:3'
    ];

    protected function getModels() {
        $this->filtered = true;
        $this->query = $this->baseModel::query();

        $theQuery = app(Pipeline::class)
            ->send($this)
            ->through($this->filters)
            ->thenReturn();
        
        $this->models = $theQuery->query->get();
    }

    public function render()
    {
        return view('livewire.model-table');
    }

    public static function travelProp($column, $model) {
        $value;
        $type = $column['type'];
        $prop = $column['name'];

        switch($type) {
            case 'method':
                $value = $model->$prop();
                break;
            case 'relationship';
            case 'route';
            case 'property':
            case 'date':
            case 'nested';
                $value = $model->$prop;
                break;
            default:
                $value = 'No Value';
        }

        if ($type === 'nested') {
            return self::travelProp($column['next'], $value);
        }

        return [
            'type' => $type, 
            'value' => $value, 
            'route' => $type === 'route' ? $column['route'] : null];
    }

    public function getQuery() {
        return $this->query;
    }

    public function delete($id) {
        $theModel = $this->models->find($id);
        $theModel->delete();
        session()->flash('successNotification', $this->baseClass . ' was deleted!');
        return redirect()->route('admin.' . Str::snake($this->baseClass) . '.index');
    }
}
