@echo off
setlocal enabledelayedexpansion

echo =======================================================
echo  SISTEMA SOINTECH - AUTOPUSH EN SEGUNDO PLANO (DAEMON)
echo =======================================================
echo  Este script detecta cambios cada 2 minutos y los sube 
echo  automaticamente a tu repositorio de GitHub.
echo  Puedes minimizar esta ventana.
echo =======================================================
echo.

:loop
git status --porcelain | findstr /R "." >nul
if %errorlevel% == 0 (
    echo.
    echo [%TIME%] Cambios detectados. Preparando Auto-Push...
    git add .
    
    for /f "tokens=2 delims==" %%i in ('wmic os get localdatetime /value') do set datetime=%%i
    set "year=!datetime:~0,4!"
    set "month=!datetime:~4,2!"
    set "day=!datetime:~6,2!"
    set "hour=!datetime:~8,2!"
    set "min=!datetime:~10,2!"
    
    git commit -m "Auto-Sync: !day!/!month!/!year! !hour!:!min!"
    git push origin main
    echo [%TIME%] Cambios subidos exitosamente a GitHub.
) else (
    echo [%TIME%] Sin cambios detectados. Esperando siguiente ciclo...
)

:: Esperar 120 segundos (2 minutos) antes de volver a verificar
timeout /t 120 /nobreak >nul
goto loop
