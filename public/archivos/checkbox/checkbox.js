
function toggleTextStyle(labelId) {
    const label = document.getElementById(labelId);
    const checkbox = document.querySelector(`input[id="${labelId.replace('label_', 'permiso_')}"]`);

    if (checkbox && checkbox.checked) {
        label.classList.add('text-green-bold'); // Cambia el texto a verde con negrita
    } else {
        label.classList.remove('text-green-bold'); // Restaura el estilo original
    }
}

