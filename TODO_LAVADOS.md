# TODO LAVADOS — Mejoras Implementadas

## ✅ Completado

### 1. CRUD Completo Funcional
- [x] `index` con filtros, paginación (15 items) y totales
- [x] `create` con validación y cálculo automático de precio
- [x] `store` con validación de moto perteneciente al cliente
- [x] `show` con historial reciente y colores por estado
- [x] `edit` con máquina de estados controlada
- [x] `update` con validación de transiciones
- [x] `destroy` con Soft Delete

### 2. Soft Deletes
- [x] Migración `add_soft_deletes_to_lavado_ordens_table`
- [x] Modelo `LavadoOrden` usa `SoftDeletes`
- [x] Papelera (`papelera.blade.php`) con listado de eliminados
- [x] Restaurar (`restaurar()`)
- [x] Eliminar definitivamente (`forzarEliminar()`)

### 3. SweetAlert2
- [x] CDN en `layouts/app.blade.php`
- [x] Toast de éxito en index, papelera
- [x] Confirmación antes de eliminar (soft delete)
- [x] Confirmación antes de eliminar definitivamente
- [x] Confirmación antes de cambiar estado

### 4. Máquina de Estados
- [x] Transiciones controladas:
  - Pendiente → En proceso, Finalizado
  - En proceso → Finalizado
  - Finalizado → (ninguna)
- [x] Validación en `update()` y `cambiarEstado()`
- [x] Select dinámico en edit con solo transiciones válidas
- [x] Botón rápido "Iniciar / Finalizar" en el listado

### 5. Historial de Estados (Audit Trail)
- [x] Tabla `lavado_estado_historials`
- [x] Modelo `LavadoEstadoHistorial`
- [x] Relación `historial()` en `LavadoOrden`
- [x] Registro automático en: crear, actualizar estado, eliminar, restaurar
- [x] Vista `historial.blade.php`
- [x] Historial reciente en `show.blade.php`

### 6. WhatsApp (Preparado)
- [x] Servicio `WhatsAppService` con soporte para:
  - UltraMsg
  - CallMeBot (gratuito)
  - Twilio
- [x] Normalización de números telefónicos (Bolivia por defecto)
- [x] Envío automático al pasar a "Finalizado"
- [x] Mensaje prediseñado con datos del lavado
- [x] Configurable vía `.env` / `config/services.php`

### 7. Mejoras UX
- [x] Colores por estado en tabla (warning, info, success)
- [x] Badges de estado en listado y detalle
- [x] Totales filtrados en index
- [x] Paginación con `withQueryString()`
- [x] Cascade filtering cliente → moto (create/edit)
- [x] Preview de precio al seleccionar servicio
- [x] Botón submit con spinner (anti-doble-click)
- [x] `old()` persistence en formularios

### 8. Fix de Relaciones
- [x] Modelo `Moto`: corregido `primaryKey` incorrecto (`placa` → `id`)
- [x] Relación `lavados()` ahora usa `moto_id`
- [x] Validación de `moto_id` perteneciente al `cliente_id`

## ⏳ Pendiente / Futuras Mejoras

- [ ] **PDF Recibo**: Generar comprobante en PDF con DomPDF
- [ ] **Select2**: Implementar búsqueda avanzada en selects grandes
- [ ] **Dashboard de Productividad**: Gráficos de lavados por trabajador, estado, fecha
- [ ] **Notificaciones Email**: Alertas adicionales vía email
- [ ] **Recordatorios automáticos**: Tareas programadas para lavados pendientes

