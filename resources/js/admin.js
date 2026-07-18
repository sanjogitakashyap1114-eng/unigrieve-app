$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function initDepartmentModal() {
    const $form = $('#addDepartmentModal form');
    const $confirmField = $('[name="password_confirmation"]');

    $form.on('submit', function (e) {
        e.preventDefault();

        // Clear previous errors
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();

        const password = $('[name="password"]').val();
        const confirmPassword = $confirmField.val();

        // Password mismatch check — show below field
        if (password !== confirmPassword) {
            $confirmField.addClass('is-invalid');
            $confirmField.after(
                '<div class="invalid-feedback">Passwords do not match.</div>'
            );
            return;
        }

        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (response) {
                $('#addDepartmentModal').modal('hide');
                form[0].reset();
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Department added successfully.',
                    confirmButtonColor: 'rgb(16, 56, 106)'
                });
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors;

                if (errors) {
                    // Show each validation error below its respective field
                    $.each(errors, function (field, messages) {
                        const $field = $(`[name="${field}"]`);
                        $field.addClass('is-invalid');
                        $field.after(
                            `<div class="invalid-feedback">${messages[0]}</div>`
                        );
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                        confirmButtonColor: 'rgb(16, 56, 106)'
                    });
                }
            }
        });
    });

    // Clear error as soon as user retypes
    $confirmField.on('input', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });
}

$(document).ready(function () {
    initDepartmentModal();
    document.querySelectorAll('.btn-remove-dept').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');

        Swal.fire({
            title: 'Delete Department?',
            text: 'This will permanently remove the department and unlink all staff. This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
});