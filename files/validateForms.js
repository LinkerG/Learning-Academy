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