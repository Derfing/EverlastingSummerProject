<div class="p-6 text-gray-900 dark:text-gray-100 container-fluid">
    <div class="row">
        <div class="col-3 my-auto text-truncate">
            {{$object->name}}
        </div>
        <div class="col-6 my-auto text-truncate">
            {{$object->data}}
        </div>
        <div class="col-3">
            <div class="row text-center">
                <div class="col-6">
                    <a class="btn btn-primary w-100" wire:click="edit">Edit</a>
                </div>
                <div class="col-6">
                    <a class="btn btn-danger w-100" wire:click="delete">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
