$(document).ready(function () {
    $(document).on(
        "input keyup",
        ".global-validate-form input[data-match], .global-validate-form input",
        function () {
            let $form = $(this).closest(".global-validate-form");
            let $confirmInput = $form.find("input[data-match]");
            let $submitBtn = $form.find('button[type="submit"]');

            if (!$confirmInput.length) return;

            if ($confirmInput.val() === "") {
                $confirmInput.removeClass("is-invalid is-valid");
                $form.find(".inline-error-msg").remove();
                $submitBtn.prop("disabled", false);
                return;
            }

            let targetName = $confirmInput.data("match"); // 'password'
            let $targetInput = $form.find(`input[name="${targetName}"]`);

            $form.find(".inline-error-msg").remove();

            if (
                $targetInput.length &&
                $confirmInput.val() !== $targetInput.val()
            ) {
                $confirmInput.removeClass("is-valid").addClass("is-invalid");

                if ($confirmInput.next(".inline-error-msg").length === 0) {
                    $confirmInput.after(`
                    <span class="text-danger text-xs fw-bold d-block mt-1 inline-error-msg">
                        <i class="bi bi-exclamation-circle me-1"></i> Password does not match!
                    </span>
                `);
                }

                $submitBtn.prop("disabled", true);
            } else {
                $confirmInput.removeClass("is-invalid").addClass("is-valid");
                $form.find(".inline-error-msg").remove();

                $submitBtn.prop("disabled", false);
            }
        },
    );

    function showInlineError($field, message) {
    $field.removeClass('is-valid').addClass('is-invalid');

    if ($field.next('.inline-error-msg').length === 0) {
        $field.after(`<span class="text-danger small d-block mt-1 inline-error-msg">${message}</span>`);
    } else {
        $field.next('.inline-error-msg').text(message);
    }
}

function clearInlineError($field) {
    $field.removeClass('is-invalid').addClass('is-valid');
    $field.next('.inline-error-msg').remove();
}

function validateField($field) {
    const rule = $field.data('rule');
    const value = $field.val().trim();

    if (rule === 'required' && !value) {
        showInlineError($field, 'This field is required.');
        return false;
    }

    if (rule === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
        showInlineError($field, 'Enter a valid email address.');
        return false;
    }

    if (rule === 'password' && value.length < 6) {
        showInlineError($field, 'Password must be at least 6 characters.');
        return false;
    }

    if ($field.attr('name') === 'password_confirmation') {
        const matchField = $(`input[name="${$field.data('match')}"]`);
        if (value !== matchField.val()) {
            showInlineError($field, 'Passwords do not match.');
            return false;
        }
    }

    clearInlineError($field);
    return true;
}

$(document).on('input blur', '.global-validate-form input', function () {
    validateField($(this));
});

$(document).on('submit', '.global-validate-form', function (e) {
    let valid = true;
    $(this).find('input').each(function () {
        if (!validateField($(this))) valid = false;
    });

    if (!valid) {
        e.preventDefault();
    }
});
    $(document).on("click", ".btn-reject-action", function () {
        var formId = $(this).data("form-id");

        Swal.fire({
            title: "Reject Application?",
            text: "This action will permanently mark the request as rejected.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText:
                '<i class="bi bi-x-circle me-1"></i> Yes, Reject',
            cancelButtonText: "Cancel",
            reverseButtons: true,
            focusCancel: true, // default focus Cancel pe — accidental reject avoid
            customClass: {
                popup: "shadow-lg",
                confirmButton: "fw-semibold",
                cancelButton: "fw-semibold",
            },
        }).then(function (result) {
            if (result.isConfirmed) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    width: "340px",
                });
                Toast.fire({
                    icon: "success",
                    title: "Rejecting application...",
                }).then(function () {
                    $("#" + formId).submit();
                });
            }
        });
    });
    // Success Alert Auto Fade — 5 sec
    if ($(".alert-success").length) {
        setTimeout(function () {
            $(".alert-success").fadeTo(800, 0, function () {
                $(this).slideUp(300, function () {
                    $(this).remove();
                });
            });
        }, 5000);
    }
});
