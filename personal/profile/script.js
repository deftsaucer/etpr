$(document).ready(function() {
    var passwordInput = $('#password');
    var confirmPasswordInput = $('#password-confirm');
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

    $('#phone').inputmask('+7 (999) 999-99-99');

    $('#profileForm').submit(function(event) {
        event.preventDefault();
    
        if ($('#password').val() !== $('#password-confirm').val()) {
            $('#password-confirm').focus();
            return false;
        }
        event.currentTarget.submit();
    });



    $('#addTenderAutoForm').on('submit', function(event) {
        event.preventDefault();
        $('#tenderResult').empty();
        $('#loadingSpinner').show();
        
        $.ajax({
            url: '/new/core/profile/searchtender.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#loadingSpinner').hide();
                $('#tenderResult').html(response);
                $('#manualLink').on('click', function(e) {
                    e.preventDefault();
                    $('#add-manual-tab').tab('show');
                });

                $('#saveButton').on('click', function(innerEvent) {
                    innerEvent.preventDefault();
                    
                    $.ajax({
                        url: '/new/core/profile/savetender.php',
                        method: 'POST',
                        data: { action: 'autoSave' },
                        success: function(response) {
                            $('#tenderResult').html(response);
                        },
                        error: function() {
                            $('#tenderResult').html('<div class="alert alert-danger">Произошла ошибка. Пожалуйста, попробуйте снова.</div>');
                        }
                    });
                });  
            },
            error: function() {
                $('#loadingSpinner').hide();
                $('#tenderResult').html('<div class="alert alert-danger">Произошла ошибка. Пожалуйста, попробуйте снова.</div>');
            }
        });
    });

    $('#addTenderManualForm').on('submit', function(event) {
        event.preventDefault();
        
        var formData = $(this).serialize();
        $.ajax({
            url: '/new/core/profile/savetender.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#manualResult').html(response);
            },
            error: function() {
                $('#manualResult').html('<div class="alert alert-danger">Произошла ошибка. Пожалуйста, попробуйте снова.</div>');
            }
        });
    });  

    $('#addCall').on('submit', function(event) {
        event.preventDefault();
        
        var formData = $(this).serialize();
        $.ajax({
            url: '/new/core/profile/savecall.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#addCallResult').html(response);
            },
            error: function() {
                $('#addCallResult').html('<div class="alert alert-danger">Произошла ошибка. Пожалуйста, попробуйте снова.</div>');
            }
        });
    }); 

    function loadTenderList() {
        $.ajax({
            url: '/new/core/profile/showtenders.php',
            method: 'POST',
            success: function(response) {
                $('#tenderListResult').html(response);
            },
            error: function() {
                $('#tenderListResult').html('<div class="alert alert-danger">Произошла ошибка. Пожалуйста, попробуйте снова.</div>');
            }
        });
    }

    $('#updateTenderList').on('click', function(event) {
        event.preventDefault();
        loadTenderList();
    });

    function loadCallsList() {
        $.ajax({
            url: '/new/core/profile/showcalls.php',
            method: 'POST',
            success: function(response) {
                $('#callsListResult').html(response);
            },
            error: function() {
                $('#callsListResult').html('<div class="alert alert-danger">Произошла ошибка. Пожалуйста, попробуйте снова.</div>');
            }
        });
    }

    $('#updateCallsList').on('click', function(event) {
        event.preventDefault();
        loadCallsList();
    });

    loadTenderList();

    loadCallsList();
});

