/**
 * JOB BASKETS - Main JavaScript File
 * All functionalities: Login, Register, Profile, Sidebar, AJAX
 */

$(document).ready(function() {
    
    // ========================================
    // CSRF TOKEN SETUP FOR ALL AJAX REQUESTS
    // ========================================
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // ========================================
    // LOGIN FORM VALIDATION & AJAX SUBMISSION
    // ========================================
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        const email = $('#email').val().trim();
        const password = $('#password').val().trim();
        const remember = $('#remember').is(':checked');
        const submitBtn = $(this).find('button[type="submit"]');
        
        // Clear previous errors
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        // Validate email
        if(email === '') {
            $('#email').addClass('is-invalid');
            $('#email').after('<div class="invalid-feedback">Please enter your email</div>');
            showNotification('Please enter your email', 'error');
            isValid = false;
        } else if(!isValidEmail(email)) {
            $('#email').addClass('is-invalid');
            $('#email').after('<div class="invalid-feedback">Please enter a valid email address</div>');
            showNotification('Please enter a valid email address', 'error');
            isValid = false;
        }
        
        // Validate password
        if(password === '') {
            $('#password').addClass('is-invalid');
            $('#password').after('<div class="invalid-feedback">Please enter your password</div>');
            showNotification('Please enter your password', 'error');
            isValid = false;
        }
        
        if(isValid) {
            // Show loading state
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Logging in...');
            submitBtn.prop('disabled', true);

            // AJAX Login
            $.ajax({
                url: '/ajax/login',
                method: 'POST',
                data: { 
                    email: email, 
                    password: password,
                    remember: remember
                },
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        showNotification(response.message || 'Login successful!', 'success');
                        setTimeout(function() {
                            window.location.href = response.redirect || '/dashboard';
                        }, 1000);
                    } else {
                        showNotification(response.message || 'Invalid credentials', 'error');
                        submitBtn.html('Login').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    let message = 'An error occurred. Please try again.';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if(xhr.status === 422) {
                        message = 'Validation error. Please check your input.';
                    } else if(xhr.status === 419) {
                        message = 'Session expired. Please refresh the page.';
                    } else if(xhr.status === 500) {
                        message = 'Server error. Please try again later.';
                    }
                    showNotification(message, 'error');
                    submitBtn.html('Login').prop('disabled', false);
                }
            });
        }
    });
    
    // ========================================
    // REGISTER FORM VALIDATION (FIXED)
    // ========================================
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        const fullname = $('#fullname').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val().trim();
        const confirm = $('#password_confirmation').val().trim();
        const submitBtn = $(this).find('button[type="submit"]');
        
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        // Validate fullname
        if(fullname === '') {
            $('#fullname').addClass('is-invalid');
            $('#fullname').after('<div class="invalid-feedback">Please enter your full name</div>');
            showNotification('Please enter your full name', 'error');
            isValid = false;
        }
        
        // Validate email
        if(email === '') {
            $('#email').addClass('is-invalid');
            $('#email').after('<div class="invalid-feedback">Please enter your email</div>');
            showNotification('Please enter your email', 'error');
            isValid = false;
        } else if(!isValidEmail(email)) {
            $('#email').addClass('is-invalid');
            $('#email').after('<div class="invalid-feedback">Please enter a valid email address</div>');
            showNotification('Please enter a valid email address', 'error');
            isValid = false;
        }
        
        // Validate password
        if(password === '') {
            $('#password').addClass('is-invalid');
            $('#password').after('<div class="invalid-feedback">Please enter a password</div>');
            showNotification('Please enter a password', 'error');
            isValid = false;
        } else if(password.length < 6) {
            $('#password').addClass('is-invalid');
            $('#password').after('<div class="invalid-feedback">Password must be at least 6 characters</div>');
            showNotification('Password must be at least 6 characters', 'error');
            isValid = false;
        }
        
        // Validate confirm password
        if(confirm === '') {
            $('#password_confirmation').addClass('is-invalid');
            $('#password_confirmation').after('<div class="invalid-feedback">Please confirm your password</div>');
            showNotification('Please confirm your password', 'error');
            isValid = false;
        } else if(confirm !== password) {
            $('#password_confirmation').addClass('is-invalid');
            $('#password_confirmation').after('<div class="invalid-feedback">Passwords do not match</div>');
            showNotification('Passwords do not match', 'error');
            isValid = false;
        }
        
        if(isValid) {
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Creating account...');
            submitBtn.prop('disabled', true);
            
            // Submit form normally (Laravel will handle)
            // Remove e.preventDefault() to allow normal form submission
            $(this).off('submit').submit();
        }
    });
    
    // ========================================
    // PROFILE FORM VALIDATION
    // ========================================
    $('#profileForm').on('submit', function(e) {
        let isValid = true;
        const fullname = $('input[name="fullname"]').val().trim();
        const phone = $('input[name="phone"]').val().trim();
        const submitBtn = $(this).find('button[type="submit"]');
        
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').remove();
        
        if(fullname === '') {
            $('input[name="fullname"]').addClass('is-invalid');
            $('input[name="fullname"]').after('<div class="invalid-feedback">Please enter your full name</div>');
            showNotification('Please enter your full name', 'error');
            isValid = false;
        }
        
        if(phone !== '' && !/^\d{10}$/.test(phone)) {
            $('input[name="phone"]').addClass('is-invalid');
            $('input[name="phone"]').after('<div class="invalid-feedback">Please enter a valid 10-digit phone number</div>');
            showNotification('Please enter a valid 10-digit phone number', 'error');
            isValid = false;
        }
        
        if(!isValid) {
            e.preventDefault();
        } else {
            // Show loading state
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
            submitBtn.prop('disabled', true);
            // Form will submit normally
        }
    });
    
    // ========================================
    // PHOTO UPLOAD PREVIEW AND VALIDATION
    // ========================================
    $('#profilePhoto').on('change', function() {
        const file = this.files[0];
        if(file) {
            // Check file size (max 1MB)
            if(file.size > 1048576) {
                showNotification('File size must be less than 1MB', 'error');
                this.value = '';
                return;
            }
            
            // Check file type
            const fileType = file.type;
            if(!fileType.match(/image\/(jpeg|jpg|png)/)) {
                showNotification('Only JPG and PNG files are allowed', 'error');
                this.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profilePreview').fadeOut(200, function() {
                    $(this).attr('src', e.target.result).fadeIn(200);
                });
            }
            reader.readAsDataURL(file);
            showNotification('Photo uploaded successfully!', 'success');
        }
    });
    
    // ========================================
    // REAL-TIME VALIDATION
    // ========================================
    
    // Email validation on blur
    $('input[type="email"]').on('blur', function() {
        const email = $(this).val().trim();
        if(email !== '' && !isValidEmail(email)) {
            $(this).addClass('is-invalid');
            if($(this).next('.invalid-feedback').length === 0) {
                $(this).after('<div class="invalid-feedback">Please enter a valid email address</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
    
    // Check email availability via AJAX (for registration)
    $('#registerForm #email').on('blur', function() {
        const email = $(this).val().trim();
        const input = $(this);
        
        if(email !== '' && isValidEmail(email)) {
            $.ajax({
                url: '/ajax/check-email',
                method: 'POST',
                data: { 
                    email: email
                },
                dataType: 'json',
                success: function(response) {
                    if(response.exists) {
                        input.addClass('is-invalid');
                        if(input.next('.invalid-feedback').length === 0) {
                            input.after('<div class="invalid-feedback">Email already registered</div>');
                        }
                        showNotification('Email already registered', 'error');
                    } else {
                        input.removeClass('is-invalid');
                        input.next('.invalid-feedback').remove();
                    }
                },
                error: function() {
                    // Silently fail - don't show error for availability check
                }
            });
        }
    });
    
    // Password strength indicator
    $('#registerForm #password').on('keyup', function() {
        const pass = $(this).val();
        let strength = 0;
        
        if(pass.length >= 6) strength++;
        if(pass.match(/[a-z]+/)) strength++;
        if(pass.match(/[A-Z]+/)) strength++;
        if(pass.match(/[0-9]+/)) strength++;
        if(pass.match(/[$@#&!]+/)) strength++;
        
        let strengthText = '';
        let strengthClass = '';
        
        switch(strength) {
            case 0:
            case 1:
                strengthText = 'Weak';
                strengthClass = 'danger';
                break;
            case 2:
            case 3:
                strengthText = 'Medium';
                strengthClass = 'warning';
                break;
            case 4:
            case 5:
                strengthText = 'Strong';
                strengthClass = 'success';
                break;
        }
        
        if(pass.length > 0) {
            if($('#password-strength').length === 0) {
                $(this).after('<div id="password-strength" class="mt-1"></div>');
            }
            $('#password-strength').html('Password strength: <span class="badge bg-' + strengthClass + '">' + strengthText + '</span>');
        } else {
            $('#password-strength').remove();
        }
    });
    
    // Confirm password match
    $('#password_confirmation').on('keyup', function() {
        const pass = $('#password').val();
        const confirm = $(this).val();
        
        if(confirm !== '') {
            if(confirm !== pass) {
                $(this).addClass('is-invalid');
                if($('#password-match').length === 0) {
                    $(this).after('<div id="password-match" class="text-danger mt-1"><small>Passwords do not match</small></div>');
                }
                $('#password-match-success').remove();
            } else {
                $(this).removeClass('is-invalid');
                $('#password-match').remove();
                if($('#password-match-success').length === 0) {
                    $(this).after('<div id="password-match-success" class="text-success mt-1"><small>Passwords match</small></div>');
                }
            }
        } else {
            $(this).removeClass('is-invalid');
            $('#password-match').remove();
            $('#password-match-success').remove();
        }
    });
    
    // Phone number validation
    $('input[name="phone"]').on('keyup', function() {
        let phone = $(this).val().replace(/\D/g, '');
        $(this).val(phone);
        
        if(phone.length > 0 && phone.length !== 10) {
            $(this).addClass('is-invalid');
            if($(this).next('.invalid-feedback').length === 0) {
                $(this).after('<div class="invalid-feedback">Phone number must be 10 digits</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
    
    // ========================================
    // HELPER FUNCTIONS
    // ========================================
    
    // Email validation regex
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    // Show notification
    function showNotification(message, type) {
        const notificationClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const notification = $(`
            <div class="alert ${notificationClass} alert-dismissible fade show" role="alert">
                <i class="fas ${icon} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('.auth-card form, .card-body').prepend(notification);
        
        setTimeout(function() {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // ========================================
    // SIDEBAR ACTIVE STATE & NAVIGATION
    // ========================================
    $('.sidebar .list-group-item[data-section]').on('click', function(e) {
        if($(this).hasClass('text-danger')) return;
        
        e.preventDefault();
        
        // Remove active class from all
        $('.sidebar .list-group-item').removeClass('active');
        
        // Add active class to clicked
        $(this).addClass('active');
        
        // Get section id
        var section = $(this).data('section');
        
        // Hide all sections with fade
        $('.content-section').fadeOut(200, function() {
            // Show selected section
            $('#' + section + '-section').fadeIn(300);
        });
        
        // Update URL hash
        window.location.hash = section;
    });

    // Handle browser back/forward buttons
    $(window).on('popstate', function() {
        var hash = window.location.hash.substring(1);
        if(hash) {
            $('.sidebar .list-group-item[data-section="' + hash + '"]').trigger('click');
        } else {
            // Default to personal details
            $('.sidebar .list-group-item[data-section="personal"]').trigger('click');
        }
    });

    // Initial load - check hash
    if(window.location.hash) {
        var hash = window.location.hash.substring(1);
        if(hash) {
            $('.sidebar .list-group-item[data-section="' + hash + '"]').trigger('click');
        }
    }
    
    // ========================================
    // AUTO-HIDE ALERTS
    // ========================================
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // ========================================
    // BOOTSTRAP INITIALIZATION
    // ========================================
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
}); // Document ready ends here