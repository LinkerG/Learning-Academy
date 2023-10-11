window.onload = function() {
    document.getElementById('importButton').addEventListener('click', crearArray);
};
 
function crearArray(){
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const content = e.target.result;
            // Procesa el contenido del archivo 
            const lines = content.split('\n');
            const students = [];

            lines.forEach(line => {
                const KeyValuePairs = line.split(',');
                const studentData = {};
                KeyValuePairs.forEach(pair => {
                    const [key,value] = pair.split(':');
                    if(key && value) {
                        studentData[key.trim()] = value.trim();
                    }
                });
                students.push(studentData);
            });
            // Enviar el array a PHP
            const xhr = new XMLHttpRequest();
            xhr.open("POST","PRUEBAS.PHP", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if(xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("datos").innerHTML = xhr.responseText;
                    console.log('se envio correctamente a PHP :)');
                }
            };
            const studentsJSON ="students=" + JSON.stringify(students);
            xhr.send(studentsJSON);
        };
        reader.readAsText(file);
    }else{
        alert('Select a file please');
    }
};