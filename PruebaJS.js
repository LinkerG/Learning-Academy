function cargarDatos(){
    var a = [1,2,3,4,5];
    const xhr = new XMLHttpRequest();
    xhr.open("POST","pruebaDatos2.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4 && xhr.status === 200) {
            console.log('se envio correctamente a PHP :)');
        }
    };
    const datos ="nums=" + JSON.stringify(a);
    xhr.send(datos);
}