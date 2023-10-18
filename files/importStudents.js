window.onload = function() {
    document.getElementById('importButton').addEventListener('click', crearArray);
};
 
function crearArray(){
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();
        const students = [];
        reader.onload = function(e) {
            const content = e.target.result;
            // Procesa el contenido del archivo 
            const lines = content.split('\n');
            

            lines.forEach(line => {
                const KeyValuePairs = line.split(',');
                const studentData = {};
                KeyValuePairs.forEach(pair => {
                    const [key,value] = pair.split(':');
                    if (key && value) {
                        const trimmedKey = key.trim();
                        const trimmedValue = value.trim();
                        
                        if (trimmedKey === 'courses') {
                            // Extraer los números entre parentesis y divididos por punto y coma
                            const coursesMatch = trimmedValue.match(/\((.*?)\)/);
                            if (coursesMatch) {
                                const coursesArray = coursesMatch[1].split(';').map(Number);
                                studentData[trimmedKey] = coursesArray;
                            } else {
                                studentData[trimmedKey] = [];
                            }
                        } else {
                            studentData[trimmedKey] = trimmedValue;
                        }
                    }
                });
                students.push(studentData);
            });
            displayTable(students);
        };
        reader.readAsText(file);
        const importBtn = document.getElementById('importButton');
        const input = document.getElementById('fileInput');
        importBtn.style.display = 'none';
        input.style.display = 'none';
    }else{
        alert('Select a file please');
    }
}

function displayTable(students) {
    const table = document.createElement('table');

    const headers = ['DNI', 'Email', 'Password', 'Name', 'Surname', 'Birth date', 'Photo Path', 'Prize', 'Courses'];

    const headerRow = document.createElement('tr');
    headers.forEach((headerText) => {
        const th = document.createElement('th');
        th.innerText = headerText;
        headerRow.appendChild(th);
    });

    table.appendChild(headerRow);

    students.forEach((student) => {
        const tr = document.createElement('tr');
    
        headers.forEach((header) => {
            const td = document.createElement('td');
            if (header.toLowerCase() === 'photo path') {
                var img = document.createElement('img');
                img.src = student.photoPath;
                img.alt = "default";
                img.classList.add('provisionalFoto');
                td.appendChild(img);
            } else if (header.toLowerCase() === 'dni') {
                td.innerText = student.dniStudent || '';
            } else if (header.toLowerCase() === 'birth date') {
                td.innerText = student.birthDate || '';
            } else if(header.toLowerCase() === 'courses'){
                td.innerText = student.courses.length || '';
            } else {
                td.innerText = student[header.split(' ').join('').toLowerCase()] || '';
            }
            tr.appendChild(td);
        });
        table.appendChild(tr);
    });
    

    const tableContainer = document.getElementById('tableContainer');
    tableContainer.innerHTML = '';
    tableContainer.appendChild(table);

    // Agregar botón de irse de la página
    const leaveButton = document.createElement('button');
    leaveButton.innerText = 'Cancel';
    leaveButton.onclick = () => {
        location.reload();
    };

    const btns = document.getElementById('btns');
    const importButton = document.createElement('button');
    importButton.innerText = 'Import';
    importButton.onclick = () => {
    const confirmation = confirm('Are you sure do you want to import this students?');
    if (confirmation) {
        table.style.display = "none";
        btns.style.display = "none";
        // Enviar el array a PHP    
        const xhr = new XMLHttpRequest();
        xhr.open("POST","manageStudents.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if(xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("datos").innerHTML = xhr.responseText;
                console.log('se envio correctamente a PHP :)');
            }
        };
        const studentsJSON ="students=" + JSON.stringify(students);
        xhr.send(studentsJSON);
    } else {
        location.reload(); // Recargar la página si no se confirma la importación
    }
    };

    importButton.classList.add('whiteBtn');
    leaveButton.classList.add('whiteBtn');
    btns.appendChild(importButton);
    btns.appendChild(leaveButton);
}