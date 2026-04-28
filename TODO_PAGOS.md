# TODO - Sistema de Pagos en Lavados

## Pasos completados ✅

### 1. Database ✅
- [x] Migración: campos `metodo_pago`, `monto_pagado`, `estado_pago`, `saldo` agregados a `lavado_ordens`
- [x] Migración ejecutada correctamente

### 2. Modelo ✅
- [x] `LavadoOrden.php` actualizado con fillable, casts y `booted()` para calcular saldo automático

### 3. Controlador ✅
- [x] `store()` - valida y calcula pago, saldo, estado_pago
- [x] `update()` - permite editar monto pagado y método de pago
- [x] `index()` - muestra total pagado además de total filtrado

### 4. Vistas ✅
- [x] `create.blade.php` - campos método de pago (efectivo/qr/efectivo+qr), monto pagado, preview de saldo
- [x] `edit.blade.php` - editar pago con recálculo de saldo
- [x] `index.blade.php` - badges de estado de pago (pagado/parcial/pendiente), columnas de pago/saldo/método
- [x] `show.blade.php` - tarjetas con info de pago destacada

### 5. Dashboard ✅
- [x] `DashboardController` - ingresos reales (solo monto_pagado)
- [x] Nuevas cards: Deuda total pendiente, Lavados sin pagar
- [x] `dashboard.blade.php` - muestra valores reales

### 6. Métodos de pago implementados ✅
- [x] 💵 Efectivo
- [x] 📱 QR
- [x] 💵📱 Efectivo + QR

---

## Estado: COMPLETO 🎉
