$(document).ready(function() {
    var passwordInput = $('#floatingPasswordRegister');
    var confirmPasswordInput = $('#floatingPasswordConfirmRegister');
    var confirmMessage = $('#passwordError');

    function validatePassword() {
        if (passwordInput.val() !== confirmPasswordInput.val()) {
            confirmPasswordInput.addClass('is-invalid');
            confirmMessage.slideDown();
        } else {
            confirmPasswordInput.removeClass('is-invalid');
            confirmMessage.slideUp();
        }
    }

    passwordInput.change(validatePassword);
    confirmPasswordInput.change(validatePassword);

    $('#floatingPhoneRegister').inputmask('+7 (999) 999-99-99');
});