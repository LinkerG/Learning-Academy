function addChangeListeners(){
    let selects = document.getElementsByClassName("selectedScore");
    for (let i = 0; i < selects.length; i++) {
        selects[i].addEventListener("change", function() {
            let selectedOption = this.options[selects[i].selectedIndex];
            let tr = selects[i].parentNode.parentNode;
            
            let dniStudent = tr.getElementsByClassName("dniStudent");
            dniStudent = dniStudent[0];

            let courseIdVal = tr.parentNode.parentNode.getElementsByClassName("courseIdValue");
            courseId = courseIdVal[0].innerHTML;

            location.href = "index.php?manage="+courseId+"&dniStudent="+dniStudent.innerText+"&newScore="+selectedOption.value;
        });
        
    }
}