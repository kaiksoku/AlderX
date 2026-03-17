// ================== Lógica trasladada desde salidascreate.blade.php ==================
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('chass_numero');
    const feedback = document.getElementById('chassis-feedback');
    const btnGuardar = document.getElementById('btn-guardar');
    const inputPlaca = document.getElementById('placa');
    const inputChassisId = document.getElementById('mov_chassis_id');

    let chassisValido = false;
    let sinMotor = false;

    function actualizarEstadoBotonGuardar() {
        if (sinMotor) {
            btnGuardar.disabled = !chassisValido;
        } else {
            btnGuardar.disabled = !(chassisValido && gensetValido);
        }
    }

    // ================= Checkbox despacho sin motor =================

    const sinMotorCheckbox = document.getElementById('sin_motor');

    if (sinMotorCheckbox) {

        sinMotorCheckbox.addEventListener('change', function () {

            sinMotor = this.checked;

            const motorFields = [
                document.getElementById('gen_numero'),
                document.getElementById('gen_id_1'),
                document.getElementsByName('gen_pv')[0],
                document.getElementsByName('gen_fecha_pv')[0],
                document.getElementsByName('gen_horometro_salida')[0],
                document.getElementsByName('gen_horometro_ingreso')[0],
                document.getElementById('gen_numero_2'),
                document.getElementById('gen_id_2'),
                document.getElementsByName('gen_pv_2')[0],
                document.getElementsByName('gen_fecha_pv_2')[0],
                document.getElementsByName('gen_horometro_salida_2')[0],
                document.getElementsByName('gen_horometro_ingreso_2')[0]
            ];

            const combustibleFields = [
                document.getElementsByName('mov_comb_galones_salida')[0],
                document.getElementsByName('mov_comb_carga')[0],
                document.getElementsByName('mov_comb_nivel_ingreso')[0],
                document.getElementsByName('mov_comb_tanque')[0],
                document.getElementsByName('mov_comb_puerta')[0],
                document.getElementsByName('mov_comb_panel_1')[0],
                document.getElementsByName('mov_comb_panel_2')[0],
                document.getElementsByName('mov_comb_galones_salida_2')[0],
                document.getElementsByName('mov_comb_carga_2')[0],
                document.getElementsByName('mov_comb_nivel_ingreso_2')[0],
                document.getElementsByName('mov_comb_tanque_2')[0],
                document.getElementsByName('mov_comb_puerta_2')[0],
                document.getElementsByName('mov_comb_panel_1_2')[0],
                document.getElementsByName('mov_comb_panel_2_2')[0]
            ];

            if (sinMotor) {

                motorFields.forEach(f => { if (f) { f.value = ''; f.disabled = true; }});
                combustibleFields.forEach(f => { if (f) { f.value = ''; f.disabled = true; }});

                if (gensetFeedback) gensetFeedback.textContent = '';

                const gensetFeedback2 = document.getElementById('genset-feedback-2');
                if (gensetFeedback2) gensetFeedback2.textContent = '';

                gensetValido = true;

            } else {

                motorFields.forEach(f => { if (f) f.disabled = false; });
                combustibleFields.forEach(f => { if (f) f.disabled = false; });

                gensetValido = false;
            }

            actualizarEstadoBotonGuardar();
        });
    }

    // ================= Validación automática de chassis =================

    let chassisTimeout;

    input.addEventListener('input', function () {

        this.value = this.value.replace(/\D/g, '');

        feedback.textContent = '';
        inputPlaca.value = '';
        inputChassisId.value = '';

        chassisValido = false;

        actualizarEstadoBotonGuardar();

        clearTimeout(chassisTimeout);

        chassisTimeout = setTimeout(validarChassis, 500);
    });

    function validarChassis() {

        const valor = input.value.trim();

        if (valor === '') {
            chassisValido = false;
            actualizarEstadoBotonGuardar();
            return;
        }

        fetch(`/ajax/validar-chassis?chass_numero=${valor}`)
            .then(res => res.json())
            .then(data => {

                switch (data.status) {

                    case 'valido':

                        feedback.textContent = '✔ Chassis válido';
                        feedback.style.color = 'green';

                        inputPlaca.value = data.placa ?? '';
                        inputChassisId.value = data.id ?? '';

                        chassisValido = true;

                    break;

                    case 'taller':

                        feedback.textContent = '⚠ Chassis en taller';
                        feedback.style.color = 'orange';

                        inputPlaca.value = '';
                        inputChassisId.value = '';

                        chassisValido = false;

                    break;

                    case 'no_existe':

                        feedback.textContent = '✖ Chassis no existe';
                        feedback.style.color = 'red';

                        inputPlaca.value = '';
                        inputChassisId.value = '';

                        chassisValido = false;

                    break;
                }

                actualizarEstadoBotonGuardar();
            })
            .catch(() => {

                feedback.textContent = '';

                chassisValido = false;

                actualizarEstadoBotonGuardar();
            });
    }

    input.addEventListener('blur', validarChassis);

    input.addEventListener('keydown', function (e) {

        if (e.key === 'Enter') {
            e.preventDefault();
            validarChassis();
        }

    });

// ================= Validación Genset PRO =================

const gensetConfig = [
    {
        input: document.getElementById('gen_numero'),
        inputId: document.getElementById('gen_id_1'),
        feedback: document.getElementById('genset-feedback'),
        valido: false,
        lastValue: ''
    },
    {
        input: document.getElementById('gen_numero_2'),
        inputId: document.getElementById('gen_id_2'),
        feedback: document.getElementById('genset-feedback-2'),
        valido: true,
        lastValue: ''
    }
];

// 🔥 NUEVO: saber cuál fue el último editado
let ultimoEditado = null;


// ================= Validar Genset =================

function validarDuplicados() {

    const g1 = gensetConfig[0];
    const g2 = gensetConfig[1];

    if (!g1?.input || !g2?.input) return true;

    const val1 = g1.input.value.trim();
    const val2 = g2.input.value.trim();

    if (val1 !== '' && val2 !== '' && val1 === val2) {

        // 🔥 SOLO marcar error en el último editado
        if (ultimoEditado) {

            if (ultimoEditado.feedback) {
                ultimoEditado.feedback.textContent = '✖ Genset duplicado';
                ultimoEditado.feedback.style.color = 'red';
            }

            ultimoEditado.valido = false;

            // 🔥 SOLO limpiar ID del que se acaba de escribir
            if (ultimoEditado.inputId) ultimoEditado.inputId.value = '';
        }

        return false;
    }

    return true;
}


// Evalúa estado global
function evaluarGensets() {

    const g1 = gensetConfig[0];
    const g2 = gensetConfig[1];

    if (!validarDuplicados()) {
        gensetValido = false;
        actualizarEstadoBotonGuardar();
        return;
    }

    let gensetValidoFinal;

    if (g2.input && g2.input.value.trim() !== '') {
        gensetValidoFinal = g1.valido && g2.valido;
    } else {
        gensetValidoFinal = g1.valido;
    }

    gensetValido = gensetValidoFinal;

    actualizarEstadoBotonGuardar();
}


// Función reutilizable de validación
function validarGensetItem(config) {

    const valor = config.input.value.trim();

    if (valor === config.lastValue) return;

    config.lastValue = valor;

    if (valor === '') {

        config.valido = (config === gensetConfig[1]);

        if (config.feedback) config.feedback.textContent = '';
        if (config.inputId) config.inputId.value = '';

        evaluarGensets();
        return;
    }

    fetch(`/ajax/validar-genset?gen_numero=${valor}`)
        .then(res => res.json())
        .then(data => {

            switch (data.status) {

                case 'valido':
                    config.feedback.textContent = '✔ Genset válido';
                    config.feedback.style.color = 'green';
                    config.inputId.value = data.id ?? '';
                    config.valido = true;
                break;

                case 'taller':
                    config.feedback.textContent = '⚠ Genset en taller';
                    config.feedback.style.color = 'orange';
                    config.valido = false;
                    if (config.inputId) config.inputId.value = '';
                break;

                case 'no_existe':
                    config.feedback.textContent = '✖ Genset no existe';
                    config.feedback.style.color = 'red';
                    config.valido = false;
                    if (config.inputId) config.inputId.value = '';
                break;
            }

            evaluarGensets();
        })
        .catch(() => {
            if (config.feedback) config.feedback.textContent = '';
            config.valido = false;
            if (config.inputId) config.inputId.value = '';
            evaluarGensets();
        });
}


// ================= EVENTOS =================

gensetConfig.forEach(config => {

    if (!config.input) return;

    config.input.addEventListener('input', function () {

        // 🔥 CLAVE: guardar quién fue el último
        ultimoEditado = config;

        this.value = this.value.replace(/\D/g, '');

        if (config.feedback) config.feedback.textContent = '';

        config.valido = false;
        config.lastValue = '';

        if (config.inputId) config.inputId.value = '';

        evaluarGensets();
    });

    config.input.addEventListener('blur', () => validarGensetItem(config));

    config.input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            validarGensetItem(config);
        }
    });

});
    // ================= Segundo Genset =================

    const toggleGenset2 = document.getElementById('toggle_genset_2');
    const genset2Section = document.getElementById('genset_2_section');
    const gensetContainer = document.getElementById('genset_container');
    const combustible2Section = document.getElementById('combustible_2_section');
    const combustibleContainer = document.getElementById('combustible_container');

    if (toggleGenset2) {

        toggleGenset2.addEventListener('change', function () {

            if (this.checked) {

                genset2Section.style.display = 'block';
                gensetContainer.classList.add('dual-genset');

                combustible2Section.style.display = 'block';
                combustibleContainer.classList.add('dual-genset');

            } else {
                genset2Section.style.display = 'none';
                gensetContainer.classList.remove('dual-genset');
                combustible2Section.style.display = 'none';
                combustibleContainer.classList.remove('dual-genset');

                // Limpiar campos de segundo motor
                document.querySelectorAll('#genset_2_section input, #genset_2_section select, #genset_2_section textarea').forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
                // Limpiar campos de combustible motor 2
                document.querySelectorAll('#combustible_2_section input, #combustible_2_section select, #combustible_2_section textarea').forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
                // Limpiar campos de marchamos motor 2 (si existe sección específica)
                var marchamos2 = document.getElementById('marchamos_2_section');
                if (marchamos2) {
                    marchamos2.querySelectorAll('input, select, textarea').forEach(input => {
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else {
                            input.value = '';
                        }
                    });
                }
            }
        });
    }

});


// ---------------- Contenedor ----------------

document.addEventListener("DOMContentLoaded", function () {

    const contenedor = document.getElementById("contenedor");

    const dependientes = [
        "previaje",
        "fecha_pv",
        "naviera",
        "setpoint",
        "damper",
        "sello_plastico",
    ].map(id => document.getElementById(id));


        function contenedorValido(valor) {
            const regex = /^[A-Za-z]{4}[0-9]{7}$/;
            return regex.test(valor);
        }

        function actualizarEstado() {
            const valor = contenedor.value.trim();
            const esValido = contenedorValido(valor);
            dependientes.forEach(campo => {
                if (!campo) return;
                campo.disabled = !esValido;
                campo.required = esValido;
                if (!esValido) {
                    campo.value = "";
                }
            });
        }

    contenedor.addEventListener("input", function () {

        this.value = this.value.toUpperCase();

        actualizarEstado();
    });

    actualizarEstado();
});


// ---------------- Hora automática ----------------

document.getElementById("btn-guardar").addEventListener("click", function(event) {

    const campoHora = document.getElementById("hora");

    if (campoHora.value === "") {

        event.preventDefault();

        const confirmar = confirm(
            "La hora está vacía.\nSe actualizará con la hora actual.\n\n¿Desea continuar?"
        );

        if (!confirmar) return;

        const ahora = new Date();

        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');

        campoHora.value = `${horas}:${minutos}`;

        this.closest("form").submit();
    }

});