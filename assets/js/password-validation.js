
document.addEventListener('DOMContentLoaded', function() {
    // Toggle para mostrar/ocultar contraseña
    const togglePassword = function() {
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const inputGroup = this.closest('.input-group');
                const passwordInput = inputGroup.querySelector('.password-input');
                const icon = this.querySelector('i');
                
                // Cambiar tipo de input
                passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                
                // Cambiar icono
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    };

    // Validación de contraseña
    const validatePassword = function() {
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmInput = document.querySelector('input[name="confirm_password"]');
        const form = document.querySelector('#usuarioModal form');
        
        if (!passwordInput || !confirmInput || !form) return;
        
        // Crear elementos de feedback
        const passwordFeedback = document.createElement('div');
        passwordFeedback.className = 'invalid-feedback';
        passwordInput.parentNode.appendChild(passwordFeedback);
        
        const confirmFeedback = document.createElement('div');
        confirmFeedback.className = 'invalid-feedback';
        confirmInput.parentNode.appendChild(confirmFeedback);
        
        // Validar al enviar el formulario
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Validar fortaleza de contraseña
            if (passwordInput.value.length < 8) {
                passwordInput.classList.add('is-invalid');
                passwordFeedback.textContent = 'La contraseña debe tener al menos 8 caracteres';
                isValid = false;
            } else if (!/[A-Z]/.test(passwordInput.value)) {
                passwordInput.classList.add('is-invalid');
                passwordFeedback.textContent = 'Debe contener al menos una mayúscula';
                isValid = false;
            } else if (!/[a-z]/.test(passwordInput.value)) {
                passwordInput.classList.add('is-invalid');
                passwordFeedback.textContent = 'Debe contener al menos una minúscula';
                isValid = false;
            } else if (!/\d/.test(passwordInput.value)) {
                passwordInput.classList.add('is-invalid');
                passwordFeedback.textContent = 'Debe contener al menos un número';
                isValid = false;
            } else {
                passwordInput.classList.remove('is-invalid');
            }
            
            // Validar coincidencia
            if (passwordInput.value !== confirmInput.value) {
                confirmInput.classList.add('is-invalid');
                confirmFeedback.textContent = 'Las contraseñas no coinciden';
                isValid = false;
            } else {
                confirmInput.classList.remove('is-invalid');
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Validación en tiempo real
        passwordInput.addEventListener('input', function() {
            if (this.value.length >= 8 && /[A-Z]/.test(this.value) && 
                /[a-z]/.test(this.value) && /\d/.test(this.value)) {
                this.classList.remove('is-invalid');
            }
        });
        
        confirmInput.addEventListener('input', function() {
            if (this.value === passwordInput.value) {
                this.classList.remove('is-invalid');
            }
        });
    };
    
    // Inicializar funciones cuando el modal se muestra
    $('#usuarioModal').on('shown.bs.modal', function() {
        togglePassword();
        validatePassword();
    });
});
