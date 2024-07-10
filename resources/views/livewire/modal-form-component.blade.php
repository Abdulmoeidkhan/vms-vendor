<div>
    <button type="button" class="btn btn-{{$colorClass}}" data-bs-toggle="modal" data-bs-target="#{{$modalId}}">
        {{$title}}
    </button>
    <div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="ModalFormLabel_{{$modalId}}"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-capitalize">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalFormLabel_{{$modalId}}">{{$name}}</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit='save'>
                        <div class="form-group">
                            <label for="name_{{$mykey}}" class="col-form-label">Name</label>
                            <input type="text" wire:model='field1' class="form-control" id="name_{{$mykey}}">
                        </div>
                        <div class="form-group">
                            <label for="display_name{{$mykey}}" class="col-form-label">
                                Display Name
                            </label>
                            <input type="text" wire:model='field2' class="form-control" id="display_name{{$mykey}}">
                        </div>
                        <div class="form-group">
                            <label for="description_{{$mykey}}" class="col-form-label">
                                Description
                            </label>
                            <input type="text" wire:model='field3' class="form-control" id="description_{{$mykey}}">
                        </div>
                        <br />
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{$name}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>