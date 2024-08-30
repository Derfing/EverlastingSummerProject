<?php

namespace App\Livewire;

use App\Models\Endpoint;
use Livewire\Component;

class CreateEndpointComponent extends Component
{
    public $name;
    public $method;
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
        if ($value == 'Number' || $value == 'String') {
            $this->inputs[$key] = ['', ''];
        } else {
            unset($this->inputs[$key]);
        }
        $this->render();
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'method' => 'required|string|max:255',
            'selects.*' => 'required|string',
            'inputs.*.*' => 'nullable|string',
        ]);

        $result = [];

        foreach ($this->selects as $index => $select) {
            $result[$select] = data_get($this->inputs, $index) ?? 'object';
        }

        $endpoint = new Endpoint();

        $endpoint->name = $this->name;
        $endpoint->method = $this->method;
        $endpoint->url = auth()->user()->name . '/' . $this->name;
        $endpoint->data = json_encode($result);
        $endpoint->user_id = auth()->user()->id;

        $endpoint->save();

        return redirect()->route('endpoints');
    }

    public function render()
    {
        return view('livewire.create-endpoint-component');
    }
}
