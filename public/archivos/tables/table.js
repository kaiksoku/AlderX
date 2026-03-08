document.addEventListener("DOMContentLoaded", function() {
  setTimeout(function() {
    var mensajesAlert = document.querySelectorAll('.mensaje-alert');
    
    mensajesAlert.forEach(function(mensajeAlert) {
      if (mensajeAlert) {
        mensajeAlert.classList.add('hidden'); // Agrega la clase "hidden" para desvanecerlo
        setTimeout(function() {
          mensajeAlert.style.display = 'none'; // Oculta completamente después de desvanecer
        }, 3400); // Espera 1 segundo para desvanecerse completamente
      }
    });
  }, 2000); // Espera inicial de 0.5 segundos
});

const searchInput = document.getElementById('form1');
const searchForm = document.getElementById('search-form');

if (searchInput && searchForm) {
  searchInput.addEventListener('input', function() {
    if (this.value === '') { 
      searchForm.submit();
    }
  });

  searchInput.addEventListener('focusout', function() {
    if (this.value === '') {
      searchForm.submit();
    }
  });

  // Cambiado a 'keydown' en lugar de 'keypress'
  searchInput.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault(); // Previene el envío automático
      searchForm.submit(); // Enviar el formulario manualmente
    }
  });
}

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});




  /* Funcion para ocultar la barra de busqueda y que solo salga cuando se posicionan sobre la lupa. 
  
  function showSearchInput() {
  const formOutline = document.querySelector('.form-outline');
  formOutline.style.display = 'inline-block';
  formOutline.querySelector('input').focus();
}

function hideSearchInput() {
  const formOutline = document.querySelector('.form-outline');
  if (!formOutline.querySelector('input').matches(':focus')) {
    formOutline.style.display = 'none';
  }
}

// Para que el botón funcione como submit solo cuando el input está activo
document.querySelector('.btn').addEventListener('click', function(event) {
  const input = document.getElementById('form1');
  if (input.style.display === 'none' || !input.value) {
    event.preventDefault();
    showSearchInput();
  } else {
    // Aquí puedes ejecutar el submit del formulario si estás en uno
    console.log('Submit action');
  }
});
*/