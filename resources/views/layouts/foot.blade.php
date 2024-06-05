<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/65cdf2029131ed19d96d0d60/1hmm7in70';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script> -->
<!--End of Tawk.to Script-->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
<script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/sidebarmenu.js')}}"></script>
<script src="{{asset('assets/js/app.min.js')}}"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js" type="text/javascript"></script>
<?php $routesIncludedTable = array('/'); ?>
@if(in_array(Request::path(), $routesIncludedTable))
<script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/js/dashboard.js')}}"></script>
@endif
<script src="{{asset('assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script>
    // CNIC NUMBER Validator
    ($("#identity").length > 0) && $("#identity").inputmask();

    function isNumeric(comp) {
        let evt = document.getElementById(comp);
        let evtValue = evt.value;

        evtValue = evtValue.replaceAll("-", "");
        evtValue = evtValue.replaceAll("_", "");
        evtValue = parseInt(evtValue)
        var regex = /^\d{13}$/;
        if (!regex.test(evtValue)) {
            evt.returnValue = false;
            evt.setCustomValidity("CNIC Must be 13 Digit Long");
            evt.reportValidity();
            if (evt.preventDefault) {
                evt.preventDefault()
            };
            return false
        } else {
            evt.setCustomValidity("");
            evt.value = evtValue
            return true
        }
    }

    ($("#contact").length > 0) && $("#contact").inputmask("+99-9999999999");

    function isContact(comp) {
        let evt = document.getElementById(comp);
        let evtValue = evt.value;

        evtValue = evtValue.replaceAll("-", "");
        evtValue = evtValue.replaceAll("_", "");
        evtValue = parseInt(evtValue)
        var regex = /^\d{12}$/;
        if (!regex.test(evtValue)) {
            evt.returnValue = false;
            evt.setCustomValidity("Phone Must be 14 Digit Long");
            evt.reportValidity();
            if (evt.preventDefault) {
                evt.preventDefault()
            };
            return false
        } else {
            evt.setCustomValidity("");
            evt.value = evtValue
            return true
        }
    }
</script>