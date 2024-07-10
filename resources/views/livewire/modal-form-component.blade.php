<div class="mb-3">
    <div class="row">
        <div class="col-md-9">
            <div class="mb-3">
                <label class="form-label">Company
                    {{$name}}</label>
                <select name="company_{{$modalId}}" class="form-select">
                    <option value="" selected disabled hidden> Select Company
                        {{$name}}
                    </option>
                    @foreach ($categories as $categorys)
                    <option wire:key="{{ $categorys->id }}" value="{{$categorys->display_name}}" {{isset($oldData) ?
                        ($oldData==$categorys->display_name ?
                        'selected' : '')
                        : ''}}>{{isset($oldData)
                        ?$oldData:$categorys->display_name}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">Add {{$name}}</label>
                <button type="button" class="btn btn-{{$colorClass}}" data-bs-toggle="modal"
                    data-bs-target="#{{$modalId}}">
                    +
                </button>
                <div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog"
                    aria-labelledby="ModalFormLabel_{{$modalId}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content text-capitalize">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalFormLabel_{{$modalId}}">Add {{$name}}</h5>
                            </div>
                            <div class="modal-body">
                                <form id="{{$name}}_form_id" name="{{$name}}_form" wire:submit="save" >
                                    <div class="form-group">
                                        <label for="name_{{$modalId}}" class="col-form-label">Name</label>
                                        <input type="text" wire:model='field1' class="form-control"
                                            id="name_{{$modalId}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="display_name_{{$modalId}}" class="col-form-label">
                                            Display Name
                                        </label>
                                        <input type="text" wire:model='field2' class="form-control"
                                            id="display_name_{{$modalId}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description_{{$modalId}}" class="col-form-label">
                                            Description
                                        </label>
                                        <input type="text" wire:model='field3' class="form-control"
                                            id="description_{{$modalId}}">
                                    </div>
                                    <br />
                                    <div class="form-group">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Add
                                            Company {{$name}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>