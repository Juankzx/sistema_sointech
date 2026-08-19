# 🚀 Roadmap del Proyecto - SoinTech

Documento de seguimiento de estado, tareas pendientes, correcciones y funcionalidades del sistema **SoinTech** (Sistema de Gestión de Servicio Técnico, POS e Inventario).

---

## 📊 Resumen de Estado del Sistema

| Módulo | Estado | Descripción |
| :--- | :---: | :--- |
| 💜 **Caja Diaria** | 🟢 Estable | Apertura, cierre asistido, arqueo, historial permanente y auto-cierre |
| 🛒 **Punto de Venta (POS)** | 🟢 Estable | Carrito, cobros, abonos OT, boletas, facturas y comprobantes |
| 📋 **Órdenes de Trabajo** | 🟢 Estable | Recepción, asignación técnica, bitácora, fotos, repuestos y entregas |
| 📦 **Inventario & Repuestos** | 🟢 Estable | Catálogo de productos, repuestos, precios de costo/venta y stock |
| 📜 **Documentos & SII** | 🟡 Funcional | Boletas/Facturas electrónicas en SII y comprobantes internos |
| 📊 **Reportes & Analítica** | 🔵 En Desarrollo | Estadísticas de ingresos, egresos y rendimiento técnico |

---

## ✅ 1. Completado (Done)

- [x] **Normalización del Sistema de Caja Diaria**:
  - Implementación de `autoCloseStaleRegisters()` para cerrar cajas pendientes de días anteriores calculando los balances reales de pagos registrados (efectivo, transferencia, tarjeta).
  - Historial de cajas cerradas siempre visible en pantalla (incluso durante turnos abiertos).
  - Distinción visual entre *Cierre Manual* (verde) y *Cierre Automático* (ámbar).
  - Arqueo ciego asistido para cajeros y vista de montos esperados para administradores.
- [x] **Integración de Pagos OT en POS e Historial de Ventas**:
  - Registro de ventas/abonos vinculados a Órdenes de Trabajo.
  - Actualización automática de estado a *Entregado* cuando el saldo de la OT queda en $0.
- [x] **Gestión Completa de Órdenes de Trabajo**:
  - Subida de fotografías múltiples de evidencia técnica (antes, avance, después).
  - Bitácora de seguimiento con envío automático de correo al cliente tras cambios de estado.
  - Registro de garantía (exclusión automática en equipos con humedad).
- [x] **Generación e Impresión de Documentos**:
  - Formato de impresión de cierres de caja y tickets de servicio.

---

## 🛠️ 2. En Verificación / Pruebas (Testing)

- [ ] **Pruebas de Arqueo Físico en Caja Diaria**:
  - Validar cuadres y descuadres con justificación obligatoria en campo de observaciones.
- [ ] **Formato Térmico de Impresión**:
  - Probar ajuste de margenes para impresoras de 80mm y 58mm en cierres e impresiones de OT.

---

## 📋 3. Pendientes Prioritarios (To Do)

- [ ] **Reportes Financieros y Gráficos**:
  - Panel de ganancias netas (Ingresos por ventas/OTs - Egresos/Costo de repuestos).
  - Filtro de movimientos por rango de fechas personalizable.
- [ ] **Control Avanzado de Stock Mínimo**:
  - Alerta visual en Dashboard cuando un repuesto o producto esté por debajo del límite stock crítico.
- [ ] **Roles y Permisos Detallados**:
  - Restricción de vistas para perfil *Técnico* (ocultar caja/montos totales si corresponde) y *Cajero*.

---

## 💡 4. Ideas & Funcionalidades Futuras (Backlog)

- [ ] **Integración con WhatsApp Business API**:
  - Envío automático de mensaje al cliente cuando su equipo esté *Listo para Entrega*.
- [ ] **Firma Digital del Cliente**:
  - Captura de firma en pantalla/tablet durante la recepción y entrega del equipo.
- [ ] **Panel de Comisiones Técnicas**:
  - Cálculo de porcentaje de comisión por mano de obra reparada por cada técnico.
- [ ] **Exportación de Informes**:
  - Descarga en Excel / PDF de inventario, ventas del mes y resumenes de caja.

---

*Última actualización: 19 de Agosto de 2026*
