<script>
    @if (Session::has('success'))
        success("{{ session('success') }}");
        @php
            Session::forget('success');
        @endphp
    @endif


    @if (Session::has('error'))
        error("{{ session('error') }}");
        @php
            Session::forget('error');
        @endphp
    @endif

    @if ($errors->any())
        Swal.fire(
            "{{ __('Form Validation Error') }}",
            "{{ __('Please Check Your Input') }}",
            'error'
        );
    @endif


    @if (Session::has('info'))
        info("{{ session('info') }}");
        @php
            Session::forget('info');
        @endphp
    @endif


    @if (Session::has('warning'))
        warning("{{ session('warning') }}");
        @php
            Session::forget('warning');
        @endphp
    @endif

    window.addEventListener('alert', event => {
        switch (event.detail.type) {
            case 'success':
                success(event.detail.message);
                break;
            case 'error':
                error(event.detail.message);
                break;
            case 'warning':
                warning(event.detail.message);
                break;
            case 'info':
                info(event.detail.message);
                break;
        }
    });

    function success(message) {
        Swal.fire(
            "{{ __('Success') }}",
            message,
            'success'
        );
    }

    function error(message) {
        Swal.fire(
            "{{ __('Error') }}",
            message,
            'error'
        );
    }

    function info(message) {
        Swal.fire(
            "{{ __('Information') }}",
            message,
            'info'
        );
    }

    function warning(message) {
        Swal.fire(
            "{{ __('Warning') }}",
            message,
            'warning'
        );
    }

    function confirmation(question, then) {
        Swal.fire(
            "{{ __('Confirmation') }}",
            question,
            'question'
        ).then(then);
    }

    function apiError() {
        Swal.fire(
            "{{ __('API Error') }}",
            "{{ __('Please Try Again Later') }}",
            'error'
        );
    }
</script>
