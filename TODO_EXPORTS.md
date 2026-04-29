# TODO: Reportes con Export PDF/Excel

**Estado**: Pendiente de aprobación e implementación.

**Plan aprobado**:
1. Instalar paquetes: maatwebsite/excel y barryvdh/laravel-dompdf
2. Agregar providers en config/app.php
3. Crear app/Exports/TrabajadoresExport.php
4. Actualizar ReporteController.php con métodos exportExcel() y exportPdf()
5. Crear resources/views/reportes/trabajadores-pdf.blade.php
6. Agregar botones export en views: trabajadores.blade.php, trabajadores-diario/semanal/mensual.blade.php
7. Agregar rutas en web.php
8. composer install && php artisan config:clear etc.
9. Probar descargas
10. Extender a reportes generales (index)

**Progreso**: ✅ 3 ✅ 4 ✅ 5 ✅ 6 ✅ 7 [ ] 1 [ ] 2 [ ] 8 [ ] 9 [ ] 10

**Pendiente**:
1. Instalar paquetes (composer require maatwebsite/excel:"^3.1" barryvdh/laravel-dompdf:"^3.0")
2. Agregar providers en config/app.php + publicar config si necesario
8. Ejecutar `composer install` y `php artisan config:clear route:clear view:clear`
9. Probar en /reportes/trabajadores (aplicar filtros, exportar Excel/PDF)
10. Opcional: Extender exports al reporte general (index)

**Notas**: Usuario aprobó plan completo.
