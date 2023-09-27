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

function openTab(tabNumber) {
    let tabContents = document.getElementsByClassName("tab-content");
    let selectedTab = document.getElementById("tab" + tabNumber);
    for (let i = 0; i < tabContents.length; i++) {
        if(tabContents[i].id == selectedTab.id){
            tabContents[i].style.zIndex = "1";
            tabContents[i].style.position = "relative";
            tabContents[i].style.display = "block";
        } else {
            tabContents[i].style.zIndex = "0";
            tabContents[i].style.position = "absolute";
            tabContents[i].style.display = "none";
        }
    }

    let tabs = document.getElementsByClassName("tab");
    let actualTab = document.getElementById("t" + tabNumber);
    for (let i = 0; i < tabs.length; i++) {
      if(tabs[i].id == actualTab.id){
            tabs[i].style.backgroundColor = "#e0e0e0";
        } else {
            tabs[i].style.backgroundColor = "#f0f0f0";
        }
    }
  }
  /*function editProfile(){
    const name = document.getElementById("profileName");
    const surname = document.getElementById("profileSurname");
    const email = document.getElementById("profileEmail");
    const photoPath = document.getElementById("profilePhoto");
    const birthDate = document.getElementById("profileBirthDate");
    const studentDni = document.getElementById("profileStudentDni");
    const editBtn = document.getElementById("edit-btn");

    const nameInput = document.getElementById("name-input");
    const surnameInput = document.getElementById("surname-input");
    const emailInput = document.getElementById("email-input");
    const photoPathInput = document.getElementById("photoPath-input");
    const birthDateInput = document.getElementById("birthDate-input");
    const dniInput = document.getElementById("dni-input");
    const passwordInput = document.getElementById("password-input");
    const saveBtn = document.getElementById("save-btn");
    const profileForm = document.getElementById("profile-form");

    editBtn.addEventListener("click", function(){
        
        name.style.display = "none";
        surname.style.display = "none";
        email.style.display = "none";
        photoPath.style.display = "none";
        birthDate.style.display = "none";
        studentDni.style.display = "none";
        
        profileForm.style.display = "block";
        nameInput.style.display = "block";
        surnameInput.style.display = "block";
        emailInput.style.display = "block";
        photoPathInput.style.display = "block";
        birthDateInput.style.display = "block";
        dniInput.style.display = "block";

        editBtn.style.display = "none";
        saveBtn.style.display = "block";

        saveBtn.addEventListener("click", function(){
            const formData = new FormData(profileForm);
            fetch("profile.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                name.textContent = data.name;
                surname.textContent = data.surname;
                email.textContent = data.email;
                birthDate.textContent = data.birthDate;
                studentDni.textContent = data.studentDni;
                if (data.photo){
                    photoPath.src = data.foto;
                }else{
                    alert("error file doesnt exist");
                }

                profileForm.style.display = "none";
                nameInput.style.display = "none";
                surnameInput.style.display = "none";
                emailInput.style.display = "none";
                photoPathInput.style.display = "none";
                birthDateInput.style.display = "none";
                dniInput.style.display = "none";

                name.style.display = "block";
                surname.style.display = "block";
                email.style.display = "block";
                photoPath.style.display = "block";
                birthDate.style.display = "block";
                studentDni.style.display = "block";

                editBtn.style.display = "block";
                saveBtn.style.display = "none";
            })
        });
    });
  }*/

  function editProfile() {
    const profileElements = document.querySelectorAll(".profile-element");
    const formElements = document.querySelectorAll(".form-element");
    const editBtn = document.getElementById("edit-btn");
    const saveBtn = document.getElementById("save-btn");
    const profileForm = document.getElementById("profile-form");


    editBtn.addEventListener("click", function () {
        toggleElements(profileElements, "none");
        toggleElements(formElements, "block");
        toggleButtons(editBtn, saveBtn);
    });


    saveBtn.addEventListener("click", function () {
        const formData = new FormData(profileForm);
        fetch("profile.php", {
            method: "POST",
            body: formData,
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error("Error en la solicitud.");
            }
        })
        .then(data => {
            if (data.success) {
                // Actualiza los elementos HTML con los nuevos datos
                updateProfile(data);
                // Actualiza las variables de sesión en JavaScript
                updateSessionVariables(data);
                toggleElements(profileElements, "block");
                toggleElements(formElements, "none");
                toggleButtons(saveBtn, editBtn);
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error al enviar los datos: " + error);
        });
    });


    function toggleElements(elements, displayValue) {
        elements.forEach(element => {
            element.style.display = displayValue;
        });
    }


    function toggleButtons(button1, button2) {
        button1.style.display = "none";
        button2.style.display = "block";
    }


    function updateProfile(data) {
        // Actualiza los elementos del perfil con los nuevos datos
        document.getElementById("profileName").textContent = "Name: " + data.name;
        document.getElementById("profileSurname").textContent = "Surname: " + data.surname;
        document.getElementById("profileEmail").textContent = "Email: " + data.email;
        document.getElementById("profileBirthDate").textContent = "Birth date: " + data.birthDate;
        document.getElementById("profileStudentDni").textContent = "DNI: " + data.studentDni;


        // Actualiza la imagen de perfil si es necesario
        const photoPath = document.getElementById("profilePhoto");
        if (data.photo) {
            photoPath.src = data.photo;
        } else {
            alert("Error: la imagen no existe");
        }
    }
}





function checkboxShow(formId){
    let p1 = document.getElementById('1');
  
    document.get="red";
    let formul = document.getElementById(formId);
    if(formul.style.visibility == "visible"){
        
        formul.style.visibility = "hidden";
        console.log(formul.style.visibility);
    } else {
        
        formul.style.visibility = "visible";
        console.log(formul.style.visibility);
    }
}

function hideForms(){
    let forms = document.getElementsByTagName("form");
    for (let i = 0; i < forms.length; i++) {
        //forms[i].style.visibility = "hidden";
    }
}
