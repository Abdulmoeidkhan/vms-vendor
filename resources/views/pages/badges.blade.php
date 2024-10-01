@auth
<style>
    div[size="A4"] {
        width: 21cm;
        height: 29.7cm;
    }

    div[size="A4"][layout="portrait"] {
        width: 29.7cm;
        height: 21cm;

    }

    @media print {

        body,
        page {
            margin: 0;
            box-shadow: 0;
        }
    }
</style>
@foreach ($ids as $key=> $id)
<x-badge id="badge-{{$key}}">
    {{$id}}
</x-badge>
@endforeach
@endauth