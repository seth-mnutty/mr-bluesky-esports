// Global UI utilities and helpers

// Flash message auto-dismiss
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss flash messages after 5 seconds
    const flashMessages = document.querySelectorAll('[x-data*="show"]');
    flashMessages.forEach(message => {
        setTimeout(() => {
            const closeBtn = message.querySelector('button');
            if (closeBtn) closeBtn.click();
        }, 5000);
    });
});

// Form validation helpers
window.validateForm = function(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('border-red-500');
        } else {
            input.classList.remove('border-red-500');
        }
    });
    
    return isValid;
};

// Image preview helper
window.previewImage = function(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
};
