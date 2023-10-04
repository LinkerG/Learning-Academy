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
            tabContents[i].classList.add("selected");
        } else {
            tabContents[i].style.zIndex = "0";
            tabContents[i].style.position = "absolute";
            tabContents[i].style.display = "none";
            tabContents[i].classList.remove("selected");
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

  function editProfile() {
    const editBtn = document.getElementById("edit-btn");
    const saveBtn = document.getElementById("save-btn");
    const profileForm = document.getElementById("profile-form");
  
    editBtn.addEventListener("click", () => toggleElements(true));
  
    function toggleElements(isEditMode) {
        const profileElements = document.querySelectorAll(".profile-element");
        const formElements = document.querySelectorAll(".form-element");
        const profileForm = document.getElementById("profile-form"); // seleccionar el formulario
      
        console.log("toggleElements llamada. Modo edición: " + isEditMode);
      
        profileElements.forEach(element => {
          element.style.display = isEditMode ? "none" : "block";
        });
      
        formElements.forEach(element => {
          element.style.display = isEditMode ? "block" : "none";
        });
      
        // También mostramos u ocultamos el formulario según el valor de isEditMode
        profileForm.style.display = isEditMode ? "block" : "none";
      
        editBtn.style.display = isEditMode ? "none" : "block";
        saveBtn.style.display = isEditMode ? "block" : "none";
      }
  
      function updateProfile(data, profileElements) {
        // Itera a través de los elementos del perfil y sus correspondientes datos
        for (const key in profileElements) {
          if (profileElements.hasOwnProperty(key)) {
            const element = profileElements[key];
            const dataKey = key.toLowerCase(); // Supongamos que los nombres de datos coinciden con los IDs de elementos en minúsculas
      
            // Verifica si el elemento y el dato correspondiente existen
            if (element && data[dataKey] !== undefined) {
              // Actualiza el contenido del elemento
              element.textContent = `${key}: ${data[dataKey]}`;
            }
          }
        }
      }
  }
  

  
  
  
  

function checkboxShow(idToHide) {
    let popupContent = document.querySelector('.popup-content');
    if(popupContent == null){
        let elementToHide = document.querySelector("#" + idToHide);
        if (elementToHide.style.display == "block") {
            elementToHide.style.display = "none";
    
        } else {
            elementToHide.style.display = "block";
    
        }
    } else {
        let elementToHide = popupContent.querySelector("#" + idToHide);
        if (elementToHide.style.display == "block") {
            elementToHide.style.display = "none";
    
        } else {
            elementToHide.style.display = "block";
    
        }
    }
}

function hideForms() {
    let forms = document.getElementsByTagName("form");
    for (let i = 0; i < forms.length; i++) {
        forms[i].style.display = "none";

    }
    let noHideforms = document.getElementsByClassName("noHide");
    for (let i = 0; i < noHideforms.length; i++) {
        noHideforms[i].style.display = "block";

    }
}

function eventosAdmin(condition) {
    skipLoader = condition == 1 ? true : false;

    // Busco los botones y el div padre
    let buttons = document.getElementsByClassName("divWindow");
    let buttonsParent = document.getElementsByClassName("tabbedWindow");
    for (let i = 0; i < buttons.length; i++) {
        // Le añado una funcion a cada boton
        buttons[i].addEventListener("click", function open() {
            
            // Elimina todos los botones que no son el que se pulsa
            let boton = buttons[i];
            for (let j = 0; j < buttons.length; j++) {
                if (boton!=buttons[j]) {
                    buttons[j].style.display = "none";
                    
                }
            }
            
            // Hace crecer ese boton transformandose en la ventana
            boton.style.transition = "width 500ms";
            boton.style.transition = "height 500ms";
            boton.style.width = "65vw";
            boton.style.height = "60vh";
            boton.style.padding = "0px";
            
            // Hace que ya no crezca al hacer hover
            boton.classList.remove("hoverable");

            // Estructura para el div/boton
            
            boton.display = "grid";

            // loader es una cortina para que sea /suave/
            let loader = document.createElement("div");
            if (!skipLoader) {
                loader.classList.add("loader");
                loader.style.zIndex = "2";
            }
            
            let text = boton.textContent;
            boton.innerHTML = "";
            if (!skipLoader) {
                boton.appendChild(loader);    
            }
            

            // Contenido del div

            // Crea las pestañas
            let tabContainer = document.createElement("div");
            tabContainer.classList.add("tab-container");
            let tabLine = document.createElement("div");
            tabLine.classList.add("tabsLine");
            let tabWindow = document.createElement("div");
            tabWindow.classList.add("tabWindow");
            for (let tabButton = 0; tabButton < buttons.length; tabButton++) {
                // Botones de las pestañas
                let tab = document.createElement("div");
                tab.classList.add("tab");
                
                selected = buttons[tabButton].textContent == "" ? true : false;
                if(selected) {
                    tab.textContent = text;
                    tab.classList.add("selected")
                } else{
                    tab.textContent = buttons[tabButton].textContent;
                }

                tab.id = "t" + tabButton;

                // Evento de las pestañas
                tab.addEventListener("click", function() {
                    openTab(tabButton);
                })

                tabLine.appendChild(tab);

                // Contenido de las pestañas
                let ventana = document.createElement("div");
                ventana.classList.add("tab-content");
                ventana.id = "tab" + tabButton;

                if(selected) ventana.classList.add("selected");

                let show = tab.innerHTML == "Manage courses" ? "courses" : "teachers";

                let toolBar = document.createElement("div");
                toolBar.classList.add("toolBar")

                let searchBar = document.createElement("form");
                let input = document.createElement("input");
                input.type = "text";
                input.id = "search";
                input.name = "search";
                searchBar.appendChild(input)
                let searchButton = document.createElement("button");
                searchButton.type = "submit";
                let searchImg = document.createElement("img");
                searchImg.src = "/Learning-Academy/img/icons/search.png";
                searchImg.alt = "lupa";
                searchImg.classList.add("tbImage");
                searchButton.appendChild(searchImg);

                searchBar.appendChild(searchButton);

                toolBar.appendChild(searchBar);

                let link = document.createElement("a");
                if(show == "courses"){
                    link.href = "addCourse.php";
                    link.textContent = "ADD";
                    let image = document.createElement("img");
                    image.src = "/Learning-Academy/img/icons/add.png";
                    image.alt = "add icon";
                    image.classList.add("tbImage");
                    link.appendChild(image);
                } 
                else {
                    link.href = "addTeacher.php";
                    link.textContent = "ADD";
                    let image = document.createElement("img");
                    image.src = "/Learning-Academy/img/icons/add.png";
                    image.alt = "add icon";
                    image.classList.add("tbImage");
                    link.appendChild(image);
                }
                             
                toolBar.appendChild(link);

                ventana.appendChild(toolBar)

                let toDraw = document.getElementById(show + "Table");
                toDraw.style.display = "block";
                let rows = toDraw.getElementsByTagName("tr");
                let numCols = rows[0].childElementCount;

                let cols = toDraw.getElementsByTagName("td", "th");
                for (let colIndex = 0; colIndex < cols.length; colIndex++) {
                    cols[colIndex].style.width = 100 / numCols + "%";
                }
                ventana.appendChild(toDraw);

                tabWindow.appendChild(ventana);
            }

            tabContainer.appendChild(tabLine);
            tabContainer.appendChild(tabWindow);
            boton.appendChild(tabContainer);
            boton.style.backgroundColor = "white";
            if (!skipLoader) {
                setTimeout(function() {
                    
                    loader.style.height = "0px";
                }, 500);
            }

            // Estiliza el div padre para que no se vea mal
            buttonsParent[0].style.marginTop = "3rem";
            buttonsParent[0].style.display = "flex";

            boton.removeEventListener("click", open);
        });
        
    }
}

function clickById(elementId) {
    toClick = document.getElementById(elementId);
    toClick.click();
}

function loadAdmin(skipLoader, elementId) {
    eventosAdmin(skipLoader);
    if(elementId != null) {
        clickById(elementId);
    }
}

function audioRoulette() {
    let audio = new Audio("/Learning-Academy/files/audio/roulette.wav");
    audio.play();
}

function closeRoulette() {
    let rouletteDiv = document.getElementById("roulette");

    rouletteDiv.style.display = "none";
}

function spinRoulette() {
    let ruleta = document.getElementById("rouletteImg");
    gira= 1200 + Math.random()*1200
    ruleta.style.transition='all 4s ease-out';
    ruleta.style.transform=`rotate(${gira}deg)`;
    let boton = document.getElementById("rouletteButton");
    boton.style.animation = "none";
    boton.style.boxShadow = "none";
    let spinAudio = new Audio("/Learning-Academy/files/audio/spin.wav");
    spinAudio.play();
    let giraDos = 0;
    let prize = "";
    ruleta.addEventListener("transitionend", function(){
        ruleta.style.transition='none';
        giraDos= gira % 360;
        ruleta.style.transform= `rotate(${giraDos}deg)`; 

        degrees = 360 - giraDos;

        if(degrees > 0 && degrees < 120) {
            prize = "discount";
            let audio = new Audio("/Learning-Academy/files/audio/discount.wav");
            audio.play();
        }
        else if (degrees > 120 && degrees < 240) {
            prize = "nothing";
            let audio = new Audio("/Learning-Academy/files/audio/nothing.mp3");
            audio.play();
        }
        else if (degrees > 240 && degrees < 360) {
            prize = "free";
            let audio = new Audio("/Learning-Academy/files/audio/free.wav");
            audio.play();
        }

        

        window.opener.document.location="index.php?prize=" + prize;

      });

}

function windowPosition(url) {
    // Calcula las coordenadas X e Y para centrar la ventana
    var ventanaX = window.innerWidth / 2 - 600 / 2 + window.screenX;
    var ventanaY = window.innerHeight / 2 - 600 / 2 + window.screenY;

    // Abre la ventana centrada
    window.open(url, "_blank", 'width=600' + ',height=600' + ',left=' + ventanaX + ',top=' + ventanaY);
}

function baja(dni, id){
    location.href = "index.php?delete=true&dni="+dni+"&id="+id;
}