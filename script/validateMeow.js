function validateMeow() {
    var content = document.getElementById('content').value;
    var errorMessage = document.getElementById('errorMessage');

    if (content.length < 5) {
        errorMessage.textContent = "Tu meow debe tener al menos 5 caracteres.";
        return false;
    }

    if (content.length > 250) {
        errorMessage.textContent = "Tu meow no puede tener más de 250 caracteres.";
        return false;
    }
    errorMessage.textContent = "";
    return true;
}