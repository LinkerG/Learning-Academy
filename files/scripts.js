function openPopup(course) {
    var popup = document.querySelector('.popup');
    var popupContent = document.querySelector('.popup-content');
    var hiddenContent = course.querySelector('.hiddenContent').innerHTML;

    popupContent.innerHTML = hiddenContent;
    popup.style.display = 'block';
}


function closePopup() {
    var popup = document.querySelector('.popup');
    popup.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {

    var divButtons = document.querySelectorAll('.divButton');
    
    divButtons.forEach(function (divButton) {
        divButton.addEventListener('click', function() {
            openPopup(divButton);
        });
    });
    
    window.onclick = function(event) {
        var popup = document.querySelector('.popup');
        if (event.target === popup) {
            closePopup();
        }
    }
});

function enrollFunction(action, courseId, dniStudent) {
    if (action == 0) {
        let wantLogin = confirm("You must be a student to enroll on this course, want to log in as a student?");
        if(wantLogin) location.href = "/Learning-Academy/close.php";
    } else if (action == 1) {
        let confirmEnroll = confirm("You want to enroll on this course?");
        if(confirmEnroll) location.href = "/Learning-Academy/courses.php?insert=1&dniStudent="+dniStudent+"&courseId="+courseId;
    }
}
function editProfile(){
    const name = document.getElementById("profileName");
    const surname = document.getElementById("profileSurname");
    const email = document.getElementById("profileEmail");
    const photo = document.getElementById("profilePhoto");
    const birthDate = document.getElementById("profileBirthDate");
    const studentDni = document.getElementById("profileStudentDni");
    const editBtn = document.getElementsByClassName("edit-btn");

    const nameInput = document.getElementById("name-input");
    const surnameInput = document.getElementById("surname-input");
    const emailInput = document.getElementById("email-input");
    const photoPathInput = document.getElementById("photoPath-input");
    const birthDateInput = document.getElementById("birthDate-input");
    const dniInput = document.getElementById("dni-input");
    const passwordInput = document.getElementById("password-input");
    const saveBtn = document.getElementById("save-btn");
    const profileForm = document.getElementById("profile-form");

    editarBtn.addEventListener("click", function(){
        
        name.style.display = "none";
        surname.style.display = "none";
        email.style.display = "none";
        photo.style.display = "none";
        birthDate.style.display = "none";
        studentDni.style.display = "none";

        nameInput.style.display = "block";
        surnameInput.style.display = "block";
        emailInput.style.display = "block";
        photoPathInput.style.display = "block";
        birthDateInput.style.display = "block";
        dniInput.style.display = "block";
        passwordInput.style.display = "block";

        editBtn.style.display = "none";
        saveBtn.style.display = "block";

        guardarBtn.addEventListener("click", function(){
            const formData = new FormData(profileForm);
            fetch("profile.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                
            })
        });
    });

}