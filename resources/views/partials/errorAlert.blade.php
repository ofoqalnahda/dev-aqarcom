@if (session('error'))
    <script>
        $(".loader-container").css("display", "none");
    </script>
    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "{{ session('error') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>
@endif

