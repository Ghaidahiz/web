
function addInput(btn) {
    const parent = btn.parentNode.parentNode;
    const newRow = document.createElement('div');
    newRow.className = 'dynamic-input-row';

    const input = btn.parentNode.querySelector('input').cloneNode(true);
    input.value = '';

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'remove-row-btn';
    removeBtn.textContent = '−';
    removeBtn.onclick = function() { newRow.remove(); };

    newRow.appendChild(input);
    newRow.appendChild(removeBtn);
    parent.appendChild(newRow);
}

function initLoginForm() {
    const form = document.getElementById('loginForm');
    if (!form) return; 

    const usernameIn  = document.getElementById('username');
    const passwordIn  = document.getElementById('password');
    const usernameErr = document.getElementById('usernameErr');
    const passwordErr = document.getElementById('passwordErr');
    const toggleBtn   = document.getElementById('togglePass');
    const submitBtn   = document.getElementById('submitBtn');

  
    if(toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isHidden        = passwordIn.type === 'password';
            passwordIn.type       = isHidden ? 'text' : 'password';
            toggleBtn.textContent = isHidden ? '🙈' : '👁️';
        });
    }

   
    usernameIn.addEventListener('input', function () { clearErr(usernameIn, usernameErr); });
    passwordIn.addEventListener('input', function () { clearErr(passwordIn, passwordErr); });

   
    form.addEventListener('submit', function (e) {
        let valid = true;

        if (usernameIn.value.trim() === '') {
            showErr(usernameIn, usernameErr, 'يرجى إدخال اسم المستخدم.');
            valid = false;
        }

        if (passwordIn.value.trim() === '') {
            showErr(passwordIn, passwordErr, 'يرجى إدخال كلمة المرور.');
            valid = false;
        }

        if (!valid) { e.preventDefault(); return; }

        
        submitBtn.textContent = 'جارٍ التحقق...';
        submitBtn.disabled    = true;
    });
}

function showErr(input, span, msg) {
    input.classList.add('invalid');
    span.textContent = msg;
}

function clearErr(input, span) {
    input.classList.remove('invalid');
    span.textContent = '';
}

function initAlerts() {
    const alertMsg = document.getElementById('alert-msg');
    
    if (alertMsg) {
        setTimeout(function() {
           
            alertMsg.style.transition = "opacity 1s ease";
            alertMsg.style.opacity = "0";
            
            setTimeout(() => {
                alertMsg.remove();
            }, 1000);
        }, 5000); 
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initNightMode();
    initLoginForm();
    initAlerts();
});