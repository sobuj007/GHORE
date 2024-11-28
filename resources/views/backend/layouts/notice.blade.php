@if (Session('success'))
    <script type="text/javascript">
        $(document).ready(function() {
            Toastify({
                text: "{{ Session('success') }}",
                duration: 3000,
                // destination: "https://github.com/apvarun/toastify-js",
                newWindow: true,
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        });
    </script>
@endif
@if (Session('error'))
    <script type="text/javascript">
        $(document).ready(function() {
            Toastify({
                text: "{{ Session('error') }}",
                duration: -1,
                newWindow: true,
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, rgb(202, 138, 4), rgb(220, 38, 38))",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        });
    </script>
@endif
