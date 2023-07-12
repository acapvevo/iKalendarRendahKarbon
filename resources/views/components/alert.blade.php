<script>
    @if (Session::has('success'))
        Swal.fire(
            "{{ __('Success') }}",
            "{{ session('success') }}",
            'success'
        );
        @php
            Session::forget('success');
        @endphp
    @endif


    @if (Session::has('error'))
        Swal.fire(
            "{{ __('Error') }}",
            "{{ session('error') }}",
            'error'
        );
        @php
            Session::forget('error');
        @endphp
    @endif

    @if ($errors->any())
        Swal.fire(
            "{{ __('Form Validation Error') }}",
            "{{ __("Please Check Your Input") }}",
            'error'
        );
    @endif


    @if (Session::has('info'))
        Swal.fire(
            "{{ __('Information') }}",
            "{{ session('info') }}",
            'info'
        );
        @php
            Session::forget('info');
        @endphp
    @endif


    @if (Session::has('warning'))
        Swal.fire(
            "{{ __('Warning') }}",
            "{{ session('warning') }}",
            'warning'
        );
        @php
            Session::forget('warning');
        @endphp
    @endif

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
            "{{ __("Please Try Again Later") }}",
            'error'
        );
    }
</script>