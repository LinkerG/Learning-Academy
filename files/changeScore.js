function addChangeListeners(){
    selects = document.getElementsByClassName("selectedScore");
    for (let i = 0; i < selects.length; i++) {
        selects[i].addEventListener("change", function() {
            let selectedOption = this.options[selects[i].selectedIndex];
            console.log(selectedOption.value);
            let tr = selects[i].parentNode.parentNode;
            
            let dniStudent = tr.getElementsByClassName("dniStudent");
            dniStudent = dniStudent[0];

            let courseId = tr.parentNode.parentNode.getElementsByTagName("input");
            courseId = courseId[0].value;
            console.log(courseId);
            console.log(dniStudent.innerText);

            location.href = "index.php?manage="+courseId+"&dniStudent="+dniStudent.innerText+"&newScore="+selectedOption.value;
        });
        
    }
}