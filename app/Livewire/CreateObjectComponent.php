<?php

namespace App\Livewire;

use App\Models\Endpoint;
use App\Models\EndpointObject;
use Livewire\Component;

class CreateObjectComponent extends Component
{
    public $name;
    public $selects = [];
    public $inputs = [];

    public function mount()
    {
        $this->addSelect();
    }

    public function addSelect()
    {
        $this->selects[] = '';
    }

    public function removeSelect($index)
    {
        unset($this->selects[$index]);
        unset($this->inputs[$index]);
    }

    public function updatedSelects($value, $key)
    {
        if ($value == 'object' || $value == 'value' || $value == 'pattern') {
            $this->inputs[$key] = ['', ''];
        } else {
            unset($this->inputs[$key]);
        }
        $this->render();
    }

    public function submit()
    {
//        $this->validate([
//            'name' => 'required|string|max:255',
//            'selects.*' => 'required|string',
//            'inputs.*.*' => 'nullable|string',
//        ]);

        $result = [];

        foreach ($this->selects as $index => $select) {
            $result[$select][\Str::random()] = data_get($this->inputs, $index) ?? 'object';
        }

        $object = new EndpointObject();

        $object->name = $this->name;
        $object->data = json_encode($result);
        $object->user_id = auth()->user()->id;

        $object->save();

        return redirect()->route('objects');
    }

    public function render()
    {
        return view('livewire.create-object-component');
    }
}
