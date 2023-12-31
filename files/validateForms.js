function validateForm(fields) {
    var errorMessage = '';
    passwordRequired = false;
    var currentDate = new Date();
    var minBirthDate = new Date(currentDate.getFullYear() - 16, currentDate.getMonth(), currentDate.getDate());

    for (var i = 0; i < fields.length; i++) {
        var field = document.getElementById(fields[i].id).value.trim();
        var fieldName = fields[i].name;
        var fieldType = fields[i].type;
        var fieldLabel = fields[i].label;

        if (field !== document.getElementById(fields[i].id).value && field.name !== "description") {
            errorMessage += 'Fields should not contain spaces\n';
        }

        if (field.length === 0 && fieldType !== 'password') {
            errorMessage += 'Please fill in the ' + fieldLabel + ' field.\n';
        }

        if (/^\s+/.test(field)) {
            errorMessage += 'The ' + fieldLabel + ' field should not start with spaces.\n';
        }

        if (fieldType === 'text' && (fieldName === 'name' || fieldName === 'surname')) {
            if (!/^[a-zA-ZñÑ ]*$/.test(field)) {
                errorMessage += 'Please enter a valid ' + fieldName +'\n';
            }
        }

        if (fieldType === 'email') {
            if (field.includes(' ')) {
                errorMessage += 'Email should not contain spaces\n';
            }
        }

        if (fields[i].type === 'checkbox' && fields[i].name === 'showPass' && document.getElementById(fields[i].id).checked) {
            // Si se está realizando una operación de agregar y se requiere una contraseña pero no se ha proporcionado, agrega el mensaje de error correspondiente
            let passwordField = document.getElementById('password').value.trim();
            if (passwordField.length === 0) {
                errorMessage += 'Please enter a password.\n';
            } else {
                if (passwordField.length < 6) {
                    errorMessage += 'Please enter a password with at least 6 characters.\n';
                }
                if (passwordField.includes(' ')) {
                    errorMessage += 'Password should not contain spaces.\n';
                }
            }
        }   

        if(fieldName === 'passwordAdd'){
            let passwordField = document.getElementById('password').value.trim();
            if (passwordField.length === 0) {
                errorMessage += 'Please enter a password.\n';
            } else {
                if (passwordField.length < 6) {
                    errorMessage += 'Please enter a password with at least 6 characters.\n';
                }
                if (passwordField.includes(' ')) {
                    errorMessage += 'Password should not contain spaces.\n';
                }
            }
        }

        if (fields[i].name === 'birthDate') {
            var birthDate = new Date(field);
            if (birthDate > currentDate) {
                errorMessage += 'Birth date cannot be in the future.\n';
            } else if (birthDate > minBirthDate) {
                errorMessage += 'You must be at least 16 years old.\n';
            }
        }

        if (fields[i].name === 'endDate') {
            var endDate = new Date(field);
            var startDate = new Date(document.getElementById('startDate').value);
            if (endDate < currentDate) {
                errorMessage += 'End date cannot be in the past.\n';
            }
            if (endDate <= startDate) {
                errorMessage += 'End date cannot be before the start date.\n';
            }
        }
    }

    if(errorMessage !== ''){
        alert(errorMessage);
        return false;
    } else {
        return true;
    }
}

