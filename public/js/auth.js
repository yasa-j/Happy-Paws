// Show and hide passwords

function togglePassword(inputId, button) {

    const passwordInput = document.getElementById(inputId);

    if (passwordInput.type === "password") {

        passwordInput.type = "text";
        button.textContent = "◉";

    } else {

        passwordInput.type = "password";
        button.textContent = "◉";
    }
}


// Registration form validation

const registerForm = document.getElementById("registerForm");

if (registerForm) {

    registerForm.addEventListener("submit", function(event) {

        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const phone = document.getElementById("phone").value;

        // Check password length
        if (password.length < 8) {

            alert("Password must contain at least 8 characters.");

            event.preventDefault();

            return;
        }


        // Check number
        if (!/[0-9]/.test(password)) {

            alert("Password must contain at least one number.");

            event.preventDefault();

            return;
        }


        // Check special character
        if (!/[^A-Za-z0-9]/.test(password)) {

            alert("Password must contain at least one special character.");

            event.preventDefault();

            return;
        }


        // Check matching passwords
        if (password !== confirmPassword) {

            alert("Passwords do not match.");

            event.preventDefault();

            return;
        }


        // Check Sri Lankan mobile number
        if (!/^7[0-9]{8}$/.test(phone)) {

            alert("Please enter a valid Sri Lankan mobile number.");

            event.preventDefault();

            return;
        }

    });

}

function togglePassword(inputId, button) {

    const input = document.getElementById(inputId);

    if (!input) {
        return;
    }

    if (input.type === "password") {

        input.type = "text";

        button.textContent = "◉";

        button.setAttribute(
            "aria-label",
            "Hide password"
        );

    } else {

        input.type = "password";

        button.textContent = "◉";

        button.setAttribute(
            "aria-label",
            "Show password"
        );
    }
}