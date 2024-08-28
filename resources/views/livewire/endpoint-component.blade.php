<div class="p-6 text-gray-900 dark:text-gray-100 container-fluid">
    <div class="row">
        <div class="col-2 my-auto text-truncate">
            {{$endpoint->name}}
        </div>
        <div class="col-1 my-auto text-truncate">
            {{$endpoint->method}}
        </div>
        <div class="col-5 my-auto text-truncate">
            {{$endpoint->data}}
        </div>
        <div class="col-1 my-auto">
            <a class="btn btn-info w-100 h-100" href="{{$endpoint->url}}">Click</a>
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
