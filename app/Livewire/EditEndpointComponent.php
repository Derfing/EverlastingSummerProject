<?php

namespace App\Livewire;

use App\Models\Endpoint;
use Livewire\Component;

class EditEndpointComponent extends Component
{
    public $endpoint;
    public $name;
    public $method;
    public $selects = [];
    public $inputs = [];

    public function mount($id)
    {
        $endpoint = Endpoint::find($id);

        $this->endpoint = $endpoint;
        $this->name = $endpoint->name;
        $this->method = $endpoint->method;

        $data = json_decode($endpoint->data, true) ?? [];
        foreach ($data as $key => $value) {
            if ($value == 'object') $value = null;
            $this->selects[] = $key;
            $this->inputs[] = $value;
        }
    }

    public function addSelect()
    {
        $this->selects[] = '';
    }

    public function removeSelect($index)
    {
        unset($this->selects[$index]);
        unset($this->inputs[$index]);
        $this->selects = array_values($this->selects);
        $this->inputs = array_values($this->inputs);
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
//        $this->validate([
//            'name' => 'required|string|max:255',
//            'method' => 'required|string|max:255',
//            'selects.*' => 'required|string',
//            'inputs.*.*' => 'nullable|string',
//        ]);

        $result = [];

        foreach ($this->selects as $index => $select) {
            $result[$select] = data_get($this->inputs, $index) ?? 'object';
        }

        $this->endpoint->name = $this->name;
        $this->endpoint->method = $this->method;
        $this->endpoint->url = auth()->user()->name . '/' . $this->name;
        $this->endpoint->data = json_encode($result);

        $this->endpoint->save();

        return redirect('/endpoints');
    }

    public function render()
    {
        return view('livewire.edit-endpoint-component');
    }
}
