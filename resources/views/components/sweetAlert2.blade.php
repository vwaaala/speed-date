<script src="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.css') }}">
<script>
    function confirmDelete(formAction = null, formMethod = 'POST', button = { color : 'danger', text: 'Yes, delete it!'}) {
        Swal.fire({
            title: '{{ __('global.areYouSure') }}',
            text: "{{ __('global.willNotBeAbleToRevert') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--bs-' + button.color + ')',
            cancelButtonColor: 'var(--bs-primary)',
            confirmButtonText: button.text
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form dynamically
                let form = document.createElement('form');

                // Use DELETE method
                form.method = 'POST';

                // Add a hidden input field to specify the method override
                form.innerHTML = '<input type="hidden" name="_method" value="' + formMethod + '">' +
                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">';

                // Determine action based on show_deleted query parameter
                form.action = formAction;

                document.body.appendChild(form);

                // Submit the form
                form.submit();
            }

        });
    }
</script>
