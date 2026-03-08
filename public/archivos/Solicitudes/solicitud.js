function addEmployee() {
    const select = document.getElementById('employee');
    const selectedOption = select.options[select.selectedIndex];

    if (!selectedOption || selectedOption.value === "") return;

    const employeeId = selectedOption.value;
    const employeeName = selectedOption.text;

    const existing = document.getElementById(`empleado-${employeeId}`);
    if (existing) return;

    const container = document.getElementById('selected-employees');

    const div = document.createElement('div');
    div.className = 'badge-employee';
    div.id = `empleado-${employeeId}`;
    div.innerHTML = `
        <span class="badge-name">${employeeName}</span>
        <span class="badge-remove" onclick="removeEmployee('${employeeId}')">&times;</span>
    `;
    container.appendChild(div);

    const inputHidden = document.createElement('input');
    inputHidden.type = 'hidden';
    inputHidden.name = 'empleados[]';
    inputHidden.value = employeeId;
    inputHidden.id = `input-empleado-${employeeId}`;
    document.getElementById('empleadosInputs')?.appendChild(inputHidden);

    updateOrderSummary();
}


function removeEmployee(id) {
    const div = document.getElementById(`empleado-${id}`);
    const input = document.getElementById(`input-empleado-${id}`);
    if (div) div.remove();
    if (input) input.remove();

    updateOrderSummary();
}

function updateOrderSummary() {
    // Restaurante seleccionado
    const restaurantSelect = document.getElementById('restaurant');
    const selectedRestaurant = restaurantSelect.options[restaurantSelect.selectedIndex]?.text || '-';
    document.getElementById('summary-restaurant').textContent = selectedRestaurant;

    // Departamento (ya viene mostrado como input deshabilitado)
    const departmentText = document.querySelector('input[disabled]')?.value || '-';
    document.getElementById('summary-department').textContent = departmentText;

    // Platos pedidos = cantidad de empleados seleccionados
    const selectedEmployees = document.querySelectorAll('#selected-employees .badge-employee');
    const cantidad = selectedEmployees.length;
    document.getElementById('summary-quantity').textContent = cantidad;

    // Total (ejemplo: Q20 por plato)
    const total = cantidad * 25;
    document.getElementById('summary-total').textContent = `Q ${total.toFixed(2)}`;
}


const selectedEmployees = document.querySelectorAll('#selected-employees .badge-employee');
