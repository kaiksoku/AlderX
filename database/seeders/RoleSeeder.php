<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roleadmin = Role::create(['name' => 'Admin']);
        $roleanalista = Role::create(['name' => 'Analista']);
        $rolesupervisor = Role::create(['name' => 'Supervisor']);
        $rolesolicitante = Role::create(['name' => 'Solicitante']);
        $roleempleado = Role::create(['name' => 'Empleado']);

        Permission::create(['name' => 'Ver Dashboard'])->syncRoles([$roleadmin]);

        Permission::create(['name' => 'Ver Empleados'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Empleados'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Empleados'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Empleados'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Departamentos'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Departamentos'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Departamentos'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Departamentos'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Usuarios'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Usuarios'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Usuarios'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Usuarios'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Roles'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Roles'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Roles'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Roles'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Chassis'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Chassis'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Chassis'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Chassis'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Genset'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Genset'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Genset'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Genset'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Entradas'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Entradas'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Entradas'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Entradas'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Salidas'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Salidas'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Salidas'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Salidas'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Reportes'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Reportes'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Reportes'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Reportes'])->assignRole([$roleadmin]);

        Permission::create(['name' => 'Ver Cobros'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Crear Cobros'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Editar Cobros'])->assignRole([$roleadmin]);
        Permission::create(['name' => 'Eliminar Cobros'])->assignRole([$roleadmin]);

    }
}
