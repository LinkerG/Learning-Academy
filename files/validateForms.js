function validateFormTeacher(){
    var name = document.getElementById('name').value.trim();
    var surname = document.getElementById('surname').value.trim();
    var birthDate = document.getElementById('birthDate').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value.trim();
    var showPassChecked = document.getElementById('showPass').checked;
    var showPhotoChecked = document.getElementById('showPhoto').checked;
    var photoInput = document.getElementById('photoPath-input');
    var photoPath = photoInput.value;
    
    if (name !== document.getElementById('name').value || 
        surname !== document.getElementById('surname').value || 
        birthDate !== document.getElementById('birthDate').value ||
        email !== document.getElementById('email').value || 
        password !== document.getElementById('password').value) {
        alert('Fields should not contain leading or trailing spaces');
        return false;
    }
    
    if (name.length === 0 || surname.length === 0 || birthDate.length === 0 || email.length === 0) {   
        alert('Please fill in all fields');
        return false;
    }
    
    if (!/^[a-zA-Z]+$/.test(name)) {
        alert('Please enter a valid name');
        return false;
    }
    
    if (!/^[a-zA-Z]+$/.test(surname)) {
        alert('Please enter a valid surname');
        return false;
    }
    
    if (!/^[a-zA-Z]+$/.test(birthDate)) {
        alert('Please enter a valid birthDate');
        return false;
    }
    
    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        alert('Please enter a valid email');
        return false;
    }
    
    if (email.includes(' ')) {
        alert('Email should not contain spaces');
        return false;
    }
    
    if (showPassChecked && password === '') {
        alert('Please enter a password');
        return false;
    }
    
    if (password.includes(' ')) {
        alert('Password should not contain spaces');
        return false;
    }
    
    if (showPhotoChecked && photoPath === '' && photoInput.files.length === 0) {    
        photoInput.value = '<?php echo $result["photoPath"]; ?>';
    }
    
    return true;
    
}



function validateForm() {
    var name = document.getElementById('name-input').value.trim();
    var surname = document.getElementById('surname-input').value.trim();
    var birthDate = document.getElementById('birthDate-input').value.trim();
    var email = document.getElementById('email-input').value.trim();
    var password = document.getElementById('password-input').value.trim();
    var showPassChecked = document.getElementById('showPass').checked;
    var showPhotoChecked = document.getElementById('showPhoto').checked;
    var photoInput = document.getElementById('photoPath-input');
    var photoPath = photoInput.value;

    if (name !== document.getElementById('name').value || 
        surname !== document.getElementById('surname').value || 
        birthDate !== document.getElementById('birthDate').value ||
        email !== document.getElementById('email').value || 
        password !== document.getElementById('password').value) {
        alert('Fields should not contain spaces');
        return false;
    }

    if (name.length === 0 || surname.length === 0 || birthDate.length === 0 || email.length === 0) {   
        alert('Please fill in all fields');
        return false;
    }

    if (!/^[a-zA-Z ]*$/.test(name)) {
        alert('Please enter a valid name');
        return false;
    }

    if (!/^[a-zA-Z ]*$/.test(surname)) {
        alert('Please enter a valid surname');
        return false;
    }

    if (!/^[a-zA-Z ]*$/.test(birthDate)) {
        alert('Please enter a valid birthDate');
        return false;
    }

    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        alert('Please enter a valid email');
        return false;
    }
    if (email.includes(' ')) {
        alert('Email should not contain spaces');
        return false;
    }
    if (showPassChecked && password === '') {
        alert('Please enter a password');
        return false;
    }
    if (showPassChecked && password.includes(' ')) {
        alert('Password should not contain spaces');
        return false;
    }
    if (showPhotoChecked && photoPath === '' && photoInput.files.length === 0) {    
        photoInput.value = '<?php echo $result["photoPath"]; ?>';
    }

    return true;
}
function validateFormStudent() {
    var name = document.getElementById('name-input').value.trim();
    var surname = document.getElementById('surname-input').value.trim();
    var email = document.getElementById('email-input').value.trim();
    var password = document.getElementById('password').value.trim();
    var showPassChecked = document.getElementById('showPass').checked;
    var showPhotoChecked = document.getElementById('showPhoto').checked;
    var photoInput = document.getElementById('photoPath-input');
    var photoPath = photoInput.value;

    if (name !== document.getElementById('name-input').value || 
        surname !== document.getElementById('surname-input').value || 
        email !== document.getElementById('email-input').value || 
        password !== document.getElementById('password').value) {
        alert('Fields should not contain spaces');
        return false;
    }

    if (name.length === 0 || surname.length === 0 || email.length === 0) {   
        alert('Please fill in all fields');
        return false;
    }

    if (!/^[a-zA-Z ]*$/.test(name)) {
        alert('Please enter a valid name');
        return false;
    }

    if (!/^[a-zA-Z ]*$/.test(surname)) {
        alert('Please enter a valid surname');
        return false;
    }

    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        alert('Please enter a valid email');
        return false;
    }

    if (email.includes(' ')) {
        alert('Email should not contain spaces');
        return false;
    }

    if (showPassChecked && password === '') {
        alert('Please enter a password');
        return false;
    }

    if (showPassChecked && password.includes(' ')) {
        alert('Password should not contain spaces');
        return false;
    }

    if (showPhotoChecked && photoPath === '' && photoInput.files.length === 0) {    
        photoInput.value = '<?php echo $result["photoPath"]; ?>';
    }

    return true;
}

function validateFormStudentSignup() {
    var name = document.getElementById('name').value.trim();
    var surname = document.getElementById('surname').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value.trim();

    if (name !== document.getElementById('name').value || 
        surname !== document.getElementById('surname').value || 
        email !== document.getElementById('email').value || 
        password !== document.getElementById('password').value) {
        alert('Fields should not contain spaces');
        return false;
    }

    if (name.length === 0 || surname.length === 0 || email.length === 0) {   
        alert('Please fill in all fields');
        return false;
    }

    if (!/^[a-zA-Z ]*$/.test(name)) {
        alert('Please enter a valid name');
        return false;
    }

    if (!/^[a-zA-Z ]*$/.test(surname)) {
        alert('Please enter a valid surname');
        return false;
    }

    if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        alert('Please enter a valid email');
        return false;
    }

    if (email.includes(' ')) {
        alert('Email should not contain spaces');
        return false;
    }

    if (showPassChecked && password === '') {
        alert('Please enter a password');
        return false;
    }

    if (showPassChecked && password.includes(' ')) {
        alert('Password should not contain spaces');
        return false;
    }

    if (showPhotoChecked && photoPath === '' && photoInput.files.length === 0) {    
        photoInput.value = '<?php echo $result["photoPath"]; ?>';
    }

    return true;
}

function validar() {
    console.log("hola");
    let values = ['name', 'surname', 'email', 'password', 'showPass'];
    let errors = []

    for (let i = 0; i < values.length; i++) {
        let fieldName = values[i];
        let field = document.getElementById(fieldName);

        if (!field) {
            continue;
        }

        if (fieldName === 'password' && !document.getElementById('showPass').checked) {
            // Skip password validation when the checkbox is not checked
            continue;
        }

        if (field.type === "checkbox") {
            let isCheck = field.checked;

            if (isCheck) {
                let password = document.getElementById("password").value;

                if (password === "") {
                    errors.push("Please enter a password");
                }
                if (password.includes(" ")) {
                    errors.push("Password must not contain spaces");
                }
            }
        } else {
            if (field.value.trim().length === 0) {
                errors.push("Field " + fieldName + " can't be empty");
            }

            if ((fieldName === "name" || fieldName === "surname") && !/^[a-zA-Z ]*$/.test(field.value)) {
                errors.push("Field " + fieldName + " must only contain letters");
            }

            if (fieldName === "email" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(field.value)) {
                errors.push("Please enter a valid email");
            }

            if (fieldName === "email" && field.value.includes(" ")) {
                errors.push("Email must not contain spaces");
            }
        }
    }

    if (errors.length === 0) {
        return true;
    } else {
        alert(errors.join('\n'));
        return false;
    }
}
