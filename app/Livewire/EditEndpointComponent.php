<?php

namespace App\Livewire;

use App\Models\Endpoint;
use Livewire\Component;

class EditEndpointComponent extends Component
{
    public $endpoint;
    public $name;
    public $method;
    public $selects = []; // Массив для хранения значений полей выбора
    public $inputs = [];  // Массив для хранения значений текстовых полей

    public function mount($id)
    {
        $endpoint = Endpoint::find($id);
        // Инициализируем данные с переданным экземпляром Endpoint
        $this->endpoint = $endpoint;
        $this->name = $endpoint->name;
        $this->method = $endpoint->method;

        // Декодируем данные из JSON и инициализируем selects и inputs
        $data = json_decode($endpoint->data, true) ?? [];
        foreach ($data as $key => $value) {
            $this->selects[] = $key;
            $this->inputs[] = $value;
        }
    }

    public function addSelect()
    {
        // Добавляем новое поле выбора с пустым значением
        $this->selects[] = '';
    }

    public function removeSelect($index)
    {
        // Удаляем поле выбора и связанные с ним текстовые поля
        unset($this->selects[$index]);
        unset($this->inputs[$index]);
        $this->selects = array_values($this->selects); // Пересобираем массивы, чтобы избежать пропусков в индексах
        $this->inputs = array_values($this->inputs);
    }

    public function updatedSelects($value, $key)
    {
        // Если выбран 'Number' или 'String', добавляем два текстовых поля для этого выбора
        if ($value == 'Number' || $value == 'String') {
            $this->inputs[$key] = ['', '']; // Два текстовых поля для конкретного выбора
        } else {
            // Если выбран не 'Number' или 'String', очищаем текстовые поля
            unset($this->inputs[$key]);
        }
        $this->render();
    }

    public function submit()
    {
        // Логика обработки формы, например, валидация и обновление
        $this->validate([
            'name' => 'required|string|max:255',
            'method' => 'required|string|max:255',
            'selects.*' => 'required|string', // Валидация для каждого выбора
            'inputs.*.*' => 'nullable|string', // Валидация для текстовых полей
        ]);

        $result = [];

        foreach ($this->selects as $index => $select) {
            $result[$select] = data_get($this->inputs, $index);
        }

        // Обновление существующего объекта Endpoint
        $this->endpoint->name = $this->name;
        $this->endpoint->method = $this->method;
        $this->endpoint->data = json_encode($result);

        $this->endpoint->save();
    }

    public function render()
    {
        return view('livewire.edit-endpoint-component');
    }
}
