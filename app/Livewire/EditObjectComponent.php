<?php

namespace App\Livewire;

use App\Models\EndpointObject;
use Livewire\Component;

class EditObjectComponent extends Component
{
    public $object;
    public $name;
    public $selects = [];
    public $inputs = [];

    public function mount($id)
    {
        $this->object = EndpointObject::findOrFail($id);
        $this->name = $this->object->name;

        // Получаем данные и декодируем JSON
        $data = json_decode($this->object->data, true);

        // Проверка, что данные правильно декодировались
        if (!is_array($data)) {
            $data = [];
        }

        // Инициализация selects и inputs
        foreach ($data as $selectType => $fields) {
            foreach ($fields as $fieldKey => $fieldValue) {
                $this->selects[] = $selectType; // Тип поля
                $this->inputs[] = $fieldValue;  // Значения полей
            }
        }
    }

    public function addSelect()
    {
        $this->selects[] = '';
        $this->inputs[] = ['', ''];
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
        if (in_array($value, ['object', 'value', 'pattern'])) {
            $this->inputs[$key] = ['', ''];
        } else {
            unset($this->inputs[$key]);
        }
    }

    public function submit()
    {
        // Валидация (раскомментируйте, если нужно)
        // $this->validate([
        //     'name' => 'required|string|max:255',
        //     'selects.*' => 'required|string',
        //     'inputs.*.*' => 'nullable|string',
        // ]);

        $result = [];

        foreach ($this->selects as $index => $select) {
            $result[$select][\Str::random()] = data_get($this->inputs, $index) ?? 'object';
        }

        $this->object->name = $this->name;
        $this->object->data = json_encode($result);

        $this->object->save();

        return redirect()->route('objects');
    }

    public function render()
    {
        return view('livewire.edit-object-component');
    }
}
