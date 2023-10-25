document.addEventListener('DOMContentLoaded', function() {
    setupToggleFunction();
});

function setupToggleFunction() {
    var toggleCheckboxes = document.querySelectorAll(".toggle-checkbox");
    toggleCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {    
            var entityId = this.getAttribute('data-id');
            var currentStatus = this.getAttribute('data-status');
            var dataType = this.getAttribute('data-type');
            var updatedStatus = currentStatus === '1' ? '0' : '1';
            this.setAttribute('data-status', updatedStatus);
            toggleEntityStatus(entityId, dataType, updatedStatus);
        });
    });
}

function toggleEntityStatus(entityId, dataType, newStatus) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "changeStatus.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("datos").innerHTML = xhr.responseText;
            console.log('La solicitud se envió correctamente');
        }
    };
    var data = "entityId=" + encodeURIComponent(entityId) + "&dataType=" + encodeURIComponent(dataType) + "&newStatus=" + encodeURIComponent(newStatus);
    xhr.send(data);
}
