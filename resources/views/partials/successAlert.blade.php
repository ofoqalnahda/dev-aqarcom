@if (session('success'))
    <script>
        $(".loader-container").css("display", "none");
    </script>
    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>
@endif
