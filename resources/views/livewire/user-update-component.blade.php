<div class="d-flex mx-auto  align-items-center gap-2">
    <span class="mx-auto">
        <a class="btn btn-outline-success" href="{{route('pages.profileUser',$user->uid)}}">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>
                <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>
            </svg>
        </a>
        @if($userStatus)
        <button class="btn btn-outline-badar" wire:click='statusUpdate(0)' data-toggle="tooltip" data-placement="top" title="Inactive User">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M4 7l16 0"></path>
                <path d="M10 11l0 6"></path>
                <path d="M14 11l0 6"></path>
                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
            </svg>
        </button>
        @else
        <button class="btn btn-outline-primary" wire:click='statusUpdate(1)' data-toggle="tooltip" data-placement="bottom" title="Restore User">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-recycle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 17l-2 2l2 2"></path>
                <path d="M10 19h9a2 2 0 0 0 1.75 -2.75l-.55 -1"></path>
                <path d="M8.536 11l-.732 -2.732l-2.732 .732"></path>
                <path d="M7.804 8.268l-4.5 7.794a2 2 0 0 0 1.506 2.89l1.141 .024"></path>
                <path d="M15.464 11l2.732 .732l.732 -2.732"></path>
                <path d="M18.196 11.732l-4.5 -7.794a2 2 0 0 0 -3.256 -.14l-.591 .976"></path>
            </svg>
        </button>
        @endif
    </span>
</div>