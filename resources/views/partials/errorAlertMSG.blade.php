@if ($errors->any())
    <script>
        $(".loader-container").css("display", "none");
    </script>
    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "{{ $errors->first() }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>
@endif

