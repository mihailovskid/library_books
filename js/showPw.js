check.onclick = togglePassword;

function togglePassword() {
    if (check.checked) password.type = "text";
    else password.type = "password";
}