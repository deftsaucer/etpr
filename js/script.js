$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault();

        var formData = {
            'login': $('#floatingLogin').val(),
            'password': $('#floatingPassword').val(),
            'remember': $('#floatingCheckbox').is(':checked')
        };

        $.ajax({
            type: 'POST',
            url: '/new/core/auth/login.php',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    window.location.href = '/new/personal/profile';
                } else {
                    $('.error-message').addClass('shake');
                    $('.error-message').text(data.message);
                    setTimeout(function() {
                        $('.error-message').removeClass('shake');
                    }, 1000);
                }
            }
        });
    });
    $('#registerForm').submit(function(event) {
        event.preventDefault();

        if ($('#floatingPasswordRegister').val() !== $('#floatingPasswordConfirmRegister').val()) {
            $('#floatingPasswordConfirmRegister').focus();
            return false;
        }

        var formData = {
            'name': $('#floatingNameRegister').val(),
            'login': $('#floatingLoginRegister').val(),
            'password': $('#floatingPasswordRegister').val(),
            'phone': $('#floatingPhoneRegister').val(),
            'remember': $('#floatingCheckboxRegister').is(':checked')
        };
        
        $.ajax({
            type: 'POST',
            url: '/new/core/auth/register.php',
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    window.location.href = '/new/personal/profile';
                } else {
                    $('.error-message').text(data.message);
                }
            }
        });
    });

    $('#formFeedback, #formOrder').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/new/core/mailer.php',
            data: $(this).serialize(),
            success: function(data) {
                $('#form-container').html(data);
                $('#form-container').addClass('d-flex align-items-center justify-content-center');
            },
            error: function() {
                $('#form-container').html(data);
                $('#form-container').addClass('d-flex align-items-center justify-content-center');
            }
        });
    });

    $('#togglePassword').click(function() {
        var passwordField = $('#floatingPassword');
        var passwordFieldType = passwordField.attr('type');
        if (passwordFieldType === 'password') {
            passwordField.attr('type', 'text'); 
            $(this).html('<img src="/new/img/eye-slash.svg" alt="SVG Image" width="20" height="20">');
        } else {
            passwordField.attr('type', 'password');
            $(this).html('<img src="/new/img/eye.svg" alt="SVG Image" width="20" height="20">');
        }
    });
});