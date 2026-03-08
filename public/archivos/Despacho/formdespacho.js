
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('chass_numero');
    const feedback = document.getElementById('chassis-feedback');
    const btnGuardar = document.getElementById('btn-guardar');
    const inputPlaca = document.getElementById('placa');

    // Solo números
    input.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
        feedback.textContent = '';
        inputPlaca.value = '';
        btnGuardar.disabled = false;
    });

    function validarChassis() {
        const valor = input.value.trim();
        if (valor === '') return;

        fetch(`{{ route('validarchassis') }}?chass_numero=${valor}`)
            .then(res => res.json())
            .then(data => {

                switch (data.status) {

                    case 'valido':
                        feedback.textContent = '✔ Chassis válido';
                        feedback.style.color = 'green';
                        inputPlaca.value = data.placa ?? '';
                        btnGuardar.disabled = false;
                        break;

                    case 'taller':
                        feedback.textContent = '⚠ Chassis en taller';
                        feedback.style.color = 'orange';
                        inputPlaca.value = '';
                        btnGuardar.disabled = true;
                        break;

                    case 'no_existe':
                        feedback.textContent = '✖ Chassis no existe';
                        feedback.style.color = 'red';
                        inputPlaca.value = '';
                        btnGuardar.disabled = true;
                        break;
                }
            })
            .catch(() => {
                feedback.textContent = '';
                btnGuardar.disabled = true;
            });
    }

    input.addEventListener('blur', validarChassis);

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            validarChassis();
        }
    });

});

// ------------------------------------------------------ Se valida que solo acepte Gensets existentes ------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------

document.addEventListener('DOMContentLoaded', function () {

    const genInput = document.getElementById('gen_numero');
    const genFeedback = document.getElementById('genset-feedback');
    const btnGuardar = document.getElementById('btn-guardar');

    // Solo números
    genInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
        genFeedback.textContent = '';
        btnGuardar.disabled = false;
    });

    function validarGenset() {
        const valor = genInput.value.trim();
        if (valor === '') return;

        fetch(`/ajax/validar-genset?gen_numero=${valor}`)
            .then(res => res.json())
            .then(data => {

                switch (data.status) {

                    case 'valido':
                        genFeedback.textContent = '✔ Genset válido';
                        genFeedback.style.color = 'green';
                        btnGuardar.disabled = false;
                        break;

                    case 'taller':
                        genFeedback.textContent = '⚠ Genset en taller';
                        genFeedback.style.color = 'orange';
                        btnGuardar.disabled = true;
                        break;

                    case 'no_existe':
                        genFeedback.textContent = '✖ Genset no existe';
                        genFeedback.style.color = 'red';
                        btnGuardar.disabled = true;
                        break;
                }
            })
            .catch(() => {
                genFeedback.textContent = '';
                btnGuardar.disabled = true;
            });
    }

    genInput.addEventListener('blur', validarGenset);

    genInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            validarGenset();
        }
    });

});

// ---------------- Los campos relacionados a Contenedor se mantienen inactivos si no se digita un Contenedor Válido ----------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------

document.addEventListener("DOMContentLoaded", function () {

    const contenedor = document.getElementById("contenedor");

    const dependientes = [
        "tipo",
        "naviera",
        "setpoint",
        "damper",
        "sello_plastico",
        "sello_botella"
    ].map(id => document.getElementById(id));

    // Validación del formato contenedor
    function contenedorValido(valor) {
        const regex = /^[A-Za-z]{4}[0-9]{7}$/;
        return regex.test(valor);
    }

    function actualizarEstado() {

        const valor = contenedor.value.trim();
        const esValido = contenedorValido(valor);

        dependientes.forEach(campo => {

            campo.disabled = !esValido;
            campo.required = esValido;

            if (!esValido) {
                campo.value = "";
            }
        });
    }

    // Forzar mayúsculas automático
    contenedor.addEventListener("input", function () {
        this.value = this.value.toUpperCase();
        actualizarEstado();
    });

    actualizarEstado();
});

document.getElementById("btn-guardar").addEventListener("click", function(event) {

    const campoHora = document.getElementById("hora");

    if (campoHora.value === "") {

        event.preventDefault(); // detener guardado momentáneo

        const confirmar = confirm(
            "La hora está vacía.\nSe actualizará con la hora actual.\n\n¿Desea continuar?"
        );

        if (!confirmar) return;

        const ahora = new Date();
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');

        campoHora.value = `${horas}:${minutos}`;

        // ahora sí enviar el formulario
        this.closest("form").submit();
    }

});

// ---------------- Si la hora se dejó vacía, al darle a guardar obligamos a actualizar a la hora actual del sistema  ---------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------

function validarHora(event) {

    let campoHora = document.getElementById("hora");

    if (campoHora.value === "") {

        let ok = confirm("La hora está vacía. Se actualizará con la hora actual. ¿Desea continuar?");

        if (!ok) {
            event.preventDefault();
            return;
        }

        let ahora = new Date();
        let horas = String(ahora.getHours()).padStart(2,'0');
        let minutos = String(ahora.getMinutes()).padStart(2,'0');

        campoHora.value = horas + ":" + minutos;
    }
}
