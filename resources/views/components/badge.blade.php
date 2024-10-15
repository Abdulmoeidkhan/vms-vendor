<div class="badge-parent row badge-print-{{$componentKey}}" style="padding: 0px 20px;">
    <div class="d-flex align-items-end">
        <div class="card-border">
            <div class="logo-child">
                <div>
                    <h4 class="text-left mx-3 my-0">
                        {{$badgeData->staff_first_name}} {{$badgeData->staff_last_name}}

                    </h4>
                    <h5 class="text-left mx-3 my-0">
                        {{$badgeData->staff_designation}}
                    </h5>
                    <h5 class="text-left mx-3 my-0">
                        {{$badgeData->companyName->company_name}}
                    </h5>
                </div>
            </div>
            <div class="d-flex my-1">
                <div id="barCode-{{$componentKey}}" class="barcode-list" custom-id="{{$badgeData->code}}"></div>
            </div>
            <div class="card-border">
                <div class="logo-child">
                    <div>
                        <h6 class="text-left mx-3">
                            {{$badgeData->staff_identity}}/{{$badgeData->code}}/{{$badgeData->staff_country}}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-border mx-4">
            <div class="logo-child mx-5">
                @if($badgeData->image)
                <img src="https://res.cloudinary.com/dj6mfrbth/image/upload/Images/{{$badgeData->uid}}.png"
                    style="height: 120px; width: 100px;" class="img-fluid" alt="Picture" />
                @endif
            </div>
        </div>
    </div>
</div>