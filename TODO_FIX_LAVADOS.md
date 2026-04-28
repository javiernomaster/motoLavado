# TODO_FIX_LAVADOS — Correcciones de Errores en Módulo Lavados

## Errores Identificados y Estado de Corrección

### 1. HTML estructural — Divs sin cerrar
- [x] `show.blade.php`: Cierres de `<div>` en cards de pago, rows y container ya estaban correctos.
- [x] `index.blade.php`: Corregido — se cerraron los `<div>` del header, totales y card.
- [x] `create.blade.php`: Estructura correcta, no requería cambios.
- [x] `edit.blade.php`: Estructura correcta, no requería cambios.

### 2. Lógica duplicada Model vs Controller (booted calcularSaldo)
- [x] `LavadoOrden.php`: El modelo **ya no tiene** `booted()` ni `calcularSaldo()`. La lógica de cálculo vive únicamente en el Controller.

### 3. Seguridad: precio_total manipulable en update
- [x] `edit.blade.php`: El campo de precio ya **no tiene** `name="precio_total"` (solo es un input readonly visual). El Controller ignora cualquier valor enviado y usa siempre `$servicio->precio`.

### 4. Controller `cobrar()` — Falta de auto-finalización al pagar completo
- [x] `LavadoOrdenController.php`: Método `cobrar()` reescrito completamente.
  - Ahora detecta si `saldo <= 0` al iniciar y redirige con mensaje informativo.
  - Al completar el pago, **cambia el estado a `Finalizado`** automáticamente.
  - Registra historial con observación clara del cobro.
  - Envía notificación WhatsApp si pasa a `Finalizado`.
  - Mensaje de éxito actualizado: "Pago completado! Lavado #X finalizado y saldado."

### 5. Archivo corrupto por edición interrumpida
- [x] `LavadoOrdenController.php`: Reconstruido completamente. Sintaxis validada con `php -l` (No syntax errors detected).

## Archivos Modificados
1. `app/Http/Controllers/LavadoOrdenController.php` — Reescrito completo
2. `resources/views/lavados/index.blade.php` — Cierres de divs
3. `resources/views/lavados/edit.blade.php` — Removido name del precio (ya estaba corregido)

## Verificación Recomendada
- Testear flujo: crear lavado → cobrar completo → verificar que pasa a `Finalizado` y notifica.
- Testear cobro parcial → verificar que mantiene estado y actualiza saldo.
- Revisar que no aparezca "ya está pagado" incorrectamente en lavados con saldo > 0.
