@echo off
title Church CMS Laravel Server
echo Checking MariaDB Server...
tasklist /fi "imagename eq mysqld.exe" | findstr /i "mysqld.exe" > nul
if errorlevel 1 (
    echo Starting MariaDB Server...
    start "" "C:\Program Files\MariaDB 13.0\bin\mysqld.exe" --defaults-file="C:\Program Files\MariaDB 13.0\data\my.ini" --console
    timeout /t 2 /nobreak > nul
)

echo Starting Church CMS Laravel Server on http://localhost:8000 ...
cd /d "D:\SOFTWARE DEVELOPMENT\church-cms-laravel"
start http://localhost:8000/login
"C:\Users\%USERNAME%\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" artisan serve --port=8000
pause
