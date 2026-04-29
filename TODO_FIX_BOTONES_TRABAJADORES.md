# TODO: Fix Botones Trabajadores - Plan Detallado

## Estado Inicial
- StoreTrabajadorRequest.php: **BROKEN** (truncado, sintaxis incompleta)
- Datos: 5 trabajadores ✓
- Layout SweetAlert2: ✓
- Rutas resource: ✓
- UpdateTrabajadorRequest: ✓

## Pasos (Completar uno por uno)

### 1. ✅ Fix StoreTrabajadorRequest.php
   - Recrear archivo completo
   - Rules iguales a Update pero sin ignore ID
   - Test: /trabajadores/create → Guardar nuevo

### 2. Verificar Datos & Show
   - php artisan tinker 'Trabajador::all()->pluck(\"id\",\"nombre\")'
   - Test: /trabajadores/{id} → Ver stats

### 3. Test Eliminar (JS)
   - /trabajadores → click Eliminar → SweetAlert → soft delete

### 4. Test Edit
   - /trabajadores/{id}/edit → Update OK

### 5. Test Papelera
   - /trabajadores/papelera → listar + restaurar

### 6. Cleanup
   - php artisan route:clear
   - php artisan optimize:clear
   - Update este TODO

**Próximo:** Ejecutar paso 1
