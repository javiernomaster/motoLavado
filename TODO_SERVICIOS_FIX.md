# TODO_FIX_SERVICIOS.md - Correcciones Módulo SERVICIOS

## Errores Identificados:
1. **papelera.blade.php**: Rutas usan $s->id en lugar de $s (model binding {servicio} falla → 404)
2. **Controller destroy()**: Check redundante lavados_count() antes soft-delete
3. **Runtime**: Verificar migraciones/datos

## Progreso:
### 1. ✅ Corregido: Estructura forms completas en papelera.blade.php
### 2. [OPCIONAL] Remover check redundante en destroy()
### 3. ✅ Test OK: Botones Restaurar/Forzar funcionales en papelera
### 4. ✅ Fix 404: Agregado withTrashed() en controller@papelera para model binding

**Test Final**: Crear servicio → eliminar → papelera → restaurar/forzar OK sin 404.

**Estado**: Revisión completa ✅ Código limpio
