$(function () {
    'use strict';
    $('#generate_key').on("click", function (e) {
        e.preventDefault();
        $.ajax({
            type: 'get', url: $('#generate_key').data('url'), success: function (data) {
                $('#app_key').val(data);

            }
        });
    });
});

$(function () {
    'use strict';
    // $("form").attr('novalidate', 'novalidate');
    const forms = $('.needs-validation');

    // Loop over them and prevent submission
    forms.on('submit', function (event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        $(this).addClass('was-validated');
    });

    $('#drop-area').on('dragover', function (e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $('#drop-area').on('dragleave', function (e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });

    $('#drop-area').on('drop', function (e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        let file = e.originalEvent.dataTransfer.files[0];
        displayImage(file);
    });

    $('#fileInput').on('change', function () {
        let file = this.files[0];
        displayImage(file);
    });

    function displayImage(file) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').html('<img src="' + e.target.result + '" alt="Preview" style="width: 100%;">');
        }
        reader.readAsDataURL(file);
    }

    $(document).on('click', '#testdb', function (e) {
        $('#testdb').html('Testing... <i class="bi bi-arrow-repeat"></i>');
        $('#testdb').removeClass('btn-success').removeClass('btn-danger').addClass('btn-dark');
        e.preventDefault();
        $.ajax({
            type: 'post', url: $('#testdb').data('url'), data: $('#dbform').serialize(), success: function (data) {
                if (data.hasOwnProperty('Error')) {
                    $('#errorMessage').html(data.Error);
                    $('#errorMessage').addClass('danger').addClass('alert-danger');
                    $('#testdb').removeClass('btn-dark').addClass('btn-danger');
                    $('.next_step').removeClass('d-block').addClass('d-none');
                    $('#testdb').html('Test Connection failed  <i class="fa fa-times "></i>');
                } else {
                    $('#errorMessage').html(data.Success);
                    $('#errorMessage').addClass('success').addClass('alert-success');
                    $('#testdb').removeClass('btn-dark').addClass('d-none');
                    $('.next_step').removeClass('d-none').addClass('d-block');
                    $('#testdb').html('Test Connection <i class="fa fa-check-circle-o "></i>');
                }
                $('#errorMessage').addClass('text-white').addClass('p-1');
            }, statusCode: {
                500: function () {
                    $('#testdb').removeClass('btn-dark').addClass('btn-danger');
                    $('#testdb').html('Test Connection <i class="fa fa-times "></i>');
                    $('#errorMessage').html("Coul not connect to database");
                    $('#errorMessage').addClass('danger').addClass('alert-danger');
                    $('#errorMessage').addClass('text-danger').addClass('p-1');
                }
            }
        });
    });
});

$(function () {
    'use strict';
    $('#lastStep').on("click", function (e) {
        $('.loader').removeClass('d-none').addClass('d-block');
        $('#content').removeClass('d-block').addClass('d-none');
    });
});

$(function () {
    'use strict';
    $('#update_db').on("click", function (e) {
        $('.loader').removeClass('d-none').addClass('d-block');
        $('#update_db').removeClass('d-block').addClass('d-none');
    });
});
