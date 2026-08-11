@echo off
setlocal enabledelayedexpansion

:: Script de Auto-Push para Sointech
echo ====================================
echo  SISTEMA SOINTECH - AUTO GIT PUSH
echo ====================================

:: Obtener mensaje de commit opcional o usar fecha actual por defecto
set "msg=%~1"
if "%msg%"=="" (
    for /f "tokens=2 delims==" %%i in ('wmic os get localdatetime /value') do set datetime=%%i
    set "year=!datetime:~0,4!"
    set "month=!datetime:~4,2!"
    set "day=!datetime:~6,2!"
    set "hour=!datetime:~8,2!"
    set "min=!datetime:~10,2!"
    set "msg=Actualizacion automatica - !day!/!month!/!year! !hour!:!min!"
)

echo.
echo [+] Agregando archivos cambiados...
git add .

echo.
echo [+] Creando commit: "%msg%"
git commit -m "%msg%"

echo.
echo [+] Subiendo cambios a GitHub (main)...
git push origin main

echo.
echo ====================================
echo  SUCCESS! CAMBIOS SUBIDOS A GITHUB.
echo ====================================
