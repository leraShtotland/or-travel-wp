# PowerShell script to deploy to Flywheel via SFTP
# You'll need to install WinSCP first: https://winscp.net/

Write-Host "====================================" -ForegroundColor Cyan
Write-Host "OR Travel - Deploy to Flywheel" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

# Configuration - UPDATE THESE WITH YOUR FLYWHEEL CREDENTIALS
$FLYWHEEL_HOST = "YOUR_SITE.flywheelsites.com"  # Replace with your Flywheel host
$FLYWHEEL_USER = "YOUR_USERNAME"                 # Replace with your username
$FLYWHEEL_PASSWORD = "YOUR_PASSWORD"             # Replace with your password
$FLYWHEEL_PORT = 22

# Paths
$LOCAL_PATH = ".\wp-content"
$REMOTE_PATH = "/wp-content"

Write-Host "To deploy your site to Flywheel, you need to:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. GET YOUR FLYWHEEL CREDENTIALS:" -ForegroundColor Green
Write-Host "   - Log into Flywheel: https://app.getflywheel.com/"
Write-Host "   - Select your site: orhorvitztravel"
Write-Host "   - Click 'Connect' -> 'SFTP'"
Write-Host "   - Copy the credentials"
Write-Host ""
Write-Host "2. UPDATE THIS SCRIPT:" -ForegroundColor Green
Write-Host "   - Edit deploy-to-flywheel.ps1"
Write-Host "   - Replace YOUR_SITE, YOUR_USERNAME, YOUR_PASSWORD with actual values"
Write-Host ""
Write-Host "3. INSTALL WINSCP (if not installed):" -ForegroundColor Green
Write-Host "   - Download from: https://winscp.net/eng/download.php"
Write-Host "   - Install with default settings"
Write-Host ""
Write-Host "4. RUN DEPLOYMENT:" -ForegroundColor Green
Write-Host "   - Run this script again after updating credentials"
Write-Host ""

# Check if credentials are updated
if ($FLYWHEEL_HOST -eq "YOUR_SITE.flywheelsites.com") {
    Write-Host "ERROR: Please update the credentials in this script first!" -ForegroundColor Red
    Write-Host "Edit deploy-to-flywheel.ps1 and update the configuration section." -ForegroundColor Yellow
    exit 1
}

# Check if WinSCP is installed
$winscpPath = "${env:ProgramFiles(x86)}\WinSCP\WinSCP.com"
if (-not (Test-Path $winscpPath)) {
    $winscpPath = "${env:ProgramFiles}\WinSCP\WinSCP.com"
    if (-not (Test-Path $winscpPath)) {
        Write-Host "ERROR: WinSCP not found. Please install it from https://winscp.net/" -ForegroundColor Red
        exit 1
    }
}

Write-Host "Deploying to Flywheel..." -ForegroundColor Cyan

# Create WinSCP script
$scriptContent = @"
open sftp://${FLYWHEEL_USER}:${FLYWHEEL_PASSWORD}@${FLYWHEEL_HOST}:${FLYWHEEL_PORT}
option batch on
option confirm off

# Upload theme
synchronize remote "$LOCAL_PATH\themes\or-travel-child" "$REMOTE_PATH/themes/or-travel-child" -delete

# Upload plugins
synchronize remote "$LOCAL_PATH\plugins\or-agent-widget" "$REMOTE_PATH/plugins/or-agent-widget" -delete
synchronize remote "$LOCAL_PATH\plugins\or-site-setup" "$REMOTE_PATH/plugins/or-site-setup" -delete

close
exit
"@

# Save script to temporary file
$tempScript = [System.IO.Path]::GetTempFileName() + ".txt"
$scriptContent | Out-File -FilePath $tempScript -Encoding ASCII

try {
    # Execute WinSCP with the script
    & $winscpPath /script=$tempScript
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host ""
        Write-Host "Deployment successful!" -ForegroundColor Green
        Write-Host ""
        Write-Host "NEXT STEPS:" -ForegroundColor Yellow
        Write-Host "1. Log into WordPress Admin: https://orhorvitztravel.flywheelsites.com/wp-admin" -ForegroundColor Cyan
        Write-Host "2. Go to Appearance -> Themes" -ForegroundColor Cyan
        Write-Host "3. Activate 'OR Travel Child' theme" -ForegroundColor Cyan
        Write-Host "4. Activate custom plugins if needed (Plugins menu)" -ForegroundColor Cyan
        Write-Host "5. Clear cache in Flywheel dashboard" -ForegroundColor Cyan
        Write-Host ""
        Write-Host "Your site should now show the updated theme!" -ForegroundColor Green
    } else {
        Write-Host "Deployment failed. Check your credentials and try again." -ForegroundColor Red
    }
} finally {
    # Clean up temp file
    if (Test-Path $tempScript) {
        Remove-Item $tempScript -Force
    }
}
