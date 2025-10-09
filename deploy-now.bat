@echo off
echo ====================================
echo OR Travel - Deploy to Flywheel
echo ====================================
echo.

echo IMPORTANT: Have you added your SSH key to Flywheel? (Y/N)
set /p added_key=
if /i not "%added_key%"=="Y" (
    echo.
    echo Please follow these steps first:
    echo 1. Go to https://app.getflywheel.com/
    echo 2. Click your profile icon - Account Settings - SSH Keys
    echo 3. Add this SSH key:
    echo.
    type C:\Users\elshtotl\.ssh\id_ed25519.pub
    echo.
    echo 4. Wait 2-3 minutes for it to activate
    echo 5. Then run this script again
    pause
    exit /b
)

echo.
echo Testing SSH connection to Flywheel...
ssh -o BatchMode=yes -o ConnectTimeout=5 lerashtotland+orhorvitztravel@ssh.getflywheel.com "echo 'Connection successful!'" 2>nul
if %ERRORLEVEL% neq 0 (
    echo.
    echo ERROR: Cannot connect to Flywheel via SSH
    echo.
    echo Please make sure:
    echo 1. You've added the SSH key to Flywheel
    echo 2. You've waited 2-3 minutes for activation
    echo 3. Your internet connection is working
    echo.
    echo Your SSH key is:
    type C:\Users\elshtotl\.ssh\id_ed25519.pub
    echo.
    pause
    exit /b
)

echo Connection successful!
echo.
echo Starting deployment...
echo.

echo [1/4] Uploading or-travel-child theme...
scp -r wp-content\themes\or-travel-child lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/themes/
if %ERRORLEVEL% equ 0 (
    echo      SUCCESS: Theme uploaded!
) else (
    echo      ERROR: Failed to upload theme
)

echo.
echo [2/4] Uploading Astra parent theme...
scp -r wp-content\themes\astra lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/themes/
if %ERRORLEVEL% equ 0 (
    echo      SUCCESS: Astra theme uploaded!
) else (
    echo      ERROR: Failed to upload Astra theme
)

echo.
echo [3/4] Uploading or-agent-widget plugin...
scp -r wp-content\plugins\or-agent-widget lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/plugins/
if %ERRORLEVEL% equ 0 (
    echo      SUCCESS: or-agent-widget plugin uploaded!
) else (
    echo      ERROR: Failed to upload or-agent-widget plugin
)

echo.
echo [4/4] Uploading or-site-setup plugin...
scp -r wp-content\plugins\or-site-setup lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/plugins/
if %ERRORLEVEL% equ 0 (
    echo      SUCCESS: or-site-setup plugin uploaded!
) else (
    echo      ERROR: Failed to upload or-site-setup plugin
)

echo.
echo ====================================
echo DEPLOYMENT COMPLETE!
echo ====================================
echo.
echo NEXT STEPS (MANUAL):
echo.
echo 1. Go to: https://orhorvitztravel.flywheelsites.com/wp-admin
echo 2. Login with your WordPress admin credentials
echo 3. Go to Appearance - Themes
echo 4. Find "OR Travel Child" and click "Activate"
echo 5. Go to Plugins
echo 6. Activate "OR Agent Widget" and "OR Site Setup"
echo 7. Clear cache in Flywheel dashboard
echo.
echo Your site should now be running the new theme!
echo.
pause
