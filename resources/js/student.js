$(document).ready(function () {
    $('#complaintForm').on('submit', function (e) {
        e.preventDefault(); 

        // 1. Checkbox validation
        if (!$('#agree').is(':checked')) {
            alert('Please check the confirmation box before submitting.');
            return false;
        }

        let submitBtn = $('#submitBtn');
        submitBtn.prop('disabled', true).text('⏳ Submitting... Please wait...');

        let formData = new FormData(this);

        // 4. AJAX Call
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            dataType: 'json',
            success: function (response) {
    
                submitBtn.prop('disabled', false).html('🚀 Submit Complaint');

                if (response.success) {
                    $('#responseMessage')
                        .removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .html('🎉 ' + response.message)
                        .show();

                  
                    $('#complaintForm')[0].reset();
                    
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                }
            },
            error: function (xhr) {
                submitBtn.prop('disabled', false).html('🚀 Submit Complaint');
                
                let errorHtml = '<ul>';
                
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                } else {
                    errorHtml += '<li>Something went wrong. Please try again later.</li>';
                }
                errorHtml += '</ul>';

                
                $('#responseMessage')
                    .removeClass('alert alert-success')
                    .addClass('alert alert-danger')
                    .html(errorHtml)
                    .show();

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }
        });
    });
});