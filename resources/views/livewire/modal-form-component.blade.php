<div>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#{{$modalId}}">
        Add Category
    </button>
    <div class="modal fade" id="{{$modalId}}" tabindex="-1" role="dialog" aria-labelledby="ModalFormLabel_{{$modalId}}"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-capitalize">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalFormLabel_{{$modalId}}">{{$name}}</h5>
                    {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <form wire:submit='save'>
                        <div class="form-group">
                            <label for="{{$field1Name}}" class="col-form-label">{{$field1Name}}</label>
                            <input type="text" wire:model='field1' class="form-control" id="{{$field1Name}}">
                        </div>
                        <div class="form-group">
                            <label for="{{$field2Name}}" class="col-form-label">
                                <script>
                                    document.write(((val)=> val.replace(/[^\w]/gi, ''))("{{$field2Name}}"))
                                </script>
                            </label>
                            <input type="text" wire:model='field2' class="form-control" id="{{$field2Name}}">
                        </div>
                        <div class="form-group">
                            <label for="{{$field3Name}}" class="col-form-label">
                                <script>
                                    document.write(((val)=> val.replace(/[^\w]/gi, ''))("{{$field2Name}}"))
                                </script>
                            </label>
                            <input type="text" wire:model='field3' class="form-control" id="{{$field3Name}}">
                        </div>
                        <br />
                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{$name}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>