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

/* Ventanas */
/*function addEvents(){
   
    let tabs = document.getElementsByClassName("tab");
   
   
    for (let i = 0; i < tabs.length; i++) {
  
        tabs[i].addEventListener("click", function(){

            openTab(i+1);}
        );
    }
}*/

function openTab(tabNumber) {
    let tabContents = document.getElementsByClassName("tab-content");
    let selectedTab = document.getElementById("tab" + tabNumber);
    for (let i = 0; i < tabContents.length; i++) {
        if(tabContents[i].id == selectedTab.id){
            tabContents[i].style.zIndex = "1";
        } else {
            tabContents[i].style.zIndex = "0";
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