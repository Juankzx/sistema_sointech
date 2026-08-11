#!/bin/bash
# =======================================================
#  SCRIPT DE DESPLIEGUE AUTOMÁTICO EN AWS LIGHTSAIL
# =======================================================

echo "=== INICIANDO DESPLIEGUE AUTOMÁTICO EN AWS LIGHTSAIL ==="
date

# Ir al directorio del proyecto
cd /var/www/sistema_sointech || exit

# 1. Obtener los últimos cambios desde GitHub
echo "[+] Ejecutando git pull..."
git pull origin main

# 2. Instalar dependencias optimizadas de Composer
echo "[+] Actualizando dependencias de Composer..."
composer install --no-dev --optimize-autoloader

# 3. Ejecutar migraciones pendientes
echo "[+] Ejecutando migraciones..."
php artisan migrate --force

# 4. Limpiar y regenerar cachés de producción
echo "[+] Optimizando caché de Laravel..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== DESPLIEGUE FINALIZADO CON ÉXITO ==="
