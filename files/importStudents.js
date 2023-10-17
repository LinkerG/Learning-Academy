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
        };
        reader.readAsText(file);
        var table = document.createElement('table');
        var tr = document.createElement('tr');
        var dni = document.createElement('th');
        dni.innerText = 'DNI';
        tr.appendChild(dni);
        var email = document.createElement('th');
        email.innerText = 'Email';
        tr.appendChild(email);
        var password = document.createElement('th');
        password.innerText = 'Password';
        tr.appendChild(password);
        var name = document.createElement('th');
        name.innerText = 'Name';
        tr.appendChild(name);
        var surname = document.createElement('th');
        surname.innerText = 'Surname';
        tr.appendChild(surname);
        var birthDate = document.createElement('th');
        birthDate.innerText = 'Birth date';
        tr.appendChild(birthDate);
        var photoPath = document.createElement('th');
        photoPath.innerText = 'Photo Path';
        tr.appendChild(photoPath);
        var prize = document.createElement('th');
        prize.innerText = 'Prize';
        tr.appendChild(prize);
        var courses = document.createElement('th');
        courses.innerText = 'Courses';
        tr.appendChild(courses);
        table.appendChild(tr);
        students.forEach(student => {
            var tr = document.createElement('tr');
            var dniStudent = document.createElement('td');
            dniStudent.innerText = student.dniStudent;
            tr.appendChild(dniStudent);
            var emailStudent = document.createElement('td');
            emailStudent.innerText = student.email;
            tr.appendChild(emailStudent);
            var passwordStudent = document.createElement('td');
            passwordStudent.innerText = student.password;
            tr.appendChild(passwordStudent);
            var nameStudent = document.createElement('td');
            nameStudent.innerText = student.name;
            tr.appendChild(nameStudent);
            var surnameStudent = document.createElement('td');
            surnameStudent.innerText = student.surname;
            tr.appendChild(surnameStudent);
            var birthDateStudent = document.createElement('td');
            birthDateStudent.innerText = student.birthDate;
            tr.appendChild(birthDateStudent);
            var photoPathStudent = document.createElement('td');
            photoPathStudent.innerText = student.photoPath;
            tr.appendChild(photoPathStudent);
            var prizeStudent = document.createElement('td');
            prizeStudent.innerText = student.prize;
            tr.appendChild(prizeStudent);
            var coursesStudent = document.createElement('td');
            coursesStudent.innerText = student.courses.length;
            tr.appendChild(coursesStudent);

            table.appendChild(tr);
        });
        const tableContainer = document.getElementById('tableContainer');
        tableContainer.appendChild(table);
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

    }else{
        alert('Select a file please');
    }
};
