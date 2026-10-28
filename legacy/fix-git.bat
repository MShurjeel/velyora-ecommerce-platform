@echo off
echo Fixing Git Index...
if exist ".git\index" del /f /q ".git\index"
git reset
echo.
echo Git index successfully restored!
