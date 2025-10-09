# PowerShell script to deploy to Flywheel via SFTP using WinSCP
# This script will prompt for credentials securely

Write-Host "====================================" -ForegroundColor Cyan
Write-Host "OR Travel - Deploy to Flywheel (SFTP)" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

# Check if WinSCP is installed - check multiple possible locations
$possiblePaths = @(
    "${env:ProgramFiles(x86)}\WinSCP\WinSCP.com",
    "${env:ProgramFiles}\WinSCP\WinSCP.com",
    "${env:LOCALAPPDATA}\Microsoft\WinGet\Packages\WinSCP.WinSCP_Microsoft.Winget.Source_8wekyb3d8bbwe\WinSCP.com",
    "C:\Program Files (x86)\WinSCP\WinSCP.com",
    "C:\Program Files\WinSCP\WinSCP.com"
)

$winscpPath = $null
foreach ($path in $possiblePaths) {
    if (Test-Path $path) {
        $winscpPath = $path
        break
    }
}

if (-not $winscpPath) {
    # Try to find WinSCP.com using where command
    try {
        $whereResult = where.exe WinSCP.com 2>$null
        if ($whereResult -and (Test-Path $whereResult[0])) {
            $winscpPath = $whereResult[0]
        }
    } catch {
        # Ignore error
    }
}

if (-not $winscpPath) {
    Write-Host "ERROR: WinSCP.com not found in any standard location." -ForegroundColor Red
    Write-Host ""
    Write-Host "WinSCP was installed but the executable cannot be located." -ForegroundColor Yellow
    Write-Host "Please try one of these options:" -ForegroundColor Yellow
    Write-Host "1. Close and reopen PowerShell/VS Code, then run this script again" -ForegroundColor Cyan
    Write-Host "2. Install WinSCP manually from: https://winscp.net/eng/download.php" -ForegroundColor Cyan
    Write-Host "3. Use the Local by Flywheel app to push changes instead" -ForegroundColor Cyan
    Write-Host ""
    pause
    exit 1
}

Write-Host "WinSCP found at: $winscpPath" -ForegroundColor Green
Write-Host ""

# Prompt for SFTP credentials
Write-Host "Please enter your Flywheel SFTP credentials:" -ForegroundColor Yellow
Write-Host "(You can find these in Flywheel Dashboard -> Your Site -> SFTP/SSH tab)" -ForegroundColor Gray
Write-Host ""

$host_input = Read-Host "SFTP Host (e.g., sftp.flywheelsites.com)"
$username = Read-Host "Username"
$password = Read-Host "Password" -AsSecureString
$port = Read-Host "Port (press Enter for default 22)"

if ([string]::IsNullOrWhiteSpace($port)) {
    $port = "22"
}

# Convert secure string to plain text for WinSCP
$BSTR = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($password)
$plainPassword = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($BSTR)

Write-Host ""
Write-Host "Connecting to Flywheel..." -ForegroundColor Cyan

# Create WinSCP script for deployment
$scriptContent = @"
option batch on
option confirm off
open sftp://${username}:${plainPassword}@${host_input}:${port}/ -hostkey=*

# Navigate to the correct remote path
cd public/wp-content/themes

# Upload or-travel-child theme
put -delete wp-content\themes\or-travel-child\* or-travel-child/

close
exit
"@

# Save script to temporary file
$tempScript = [System.IO.Path]::GetTempFileName() + ".txt"
$scriptContent | Out-File -FilePath $tempScript -Encoding ASCII

try {
    Write-Host ""
    Write-Host "Deploying theme to Flywheel..." -ForegroundColor Cyan
    Write-Host ""
    
    # Execute WinSCP with the script
    & $winscpPath /log="$env:TEMP\winscp_deploy.log" /script=$tempScript
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host ""
        Write-Host "=====================================" -ForegroundColor Green
        Write-Host "DEPLOYMENT SUCCESSFUL!" -ForegroundColor Green
        Write-Host "=====================================" -ForegroundColor Green
        Write-Host ""
        Write-Host "Your theme has been uploaded to Flywheel." -ForegroundColor White
        Write-Host ""
        Write-Host "NEXT STEPS:" -ForegroundColor Yellow
        Write-Host "1. Visit: https://orhorvitztravel.flywheelsites.com/wp-admin" -ForegroundColor Cyan
        Write-Host "2. Go to Appearance -> Themes" -ForegroundColor Cyan
        Write-Host "3. Activate 'OR Travel Child' theme if not already active" -ForegroundColor Cyan
        Write-Host "4. Clear cache in Flywheel dashboard" -ForegroundColor Cyan
        Write-Host ""
        Write-Host "Your site should now show the updated theme!" -ForegroundColor Green
        Write-Host ""
    } else {
        Write-Host ""
        Write-Host "=====================================" -ForegroundColor Red
        Write-Host "DEPLOYMENT FAILED" -ForegroundColor Red
        Write-Host "=====================================" -ForegroundColor Red
        Write-Host ""
        Write-Host "Please check the log file for details:" -ForegroundColor Yellow
        Write-Host "$env:TEMP\winscp_deploy.log" -ForegroundColor Gray
        Write-Host ""
        Write-Host "Common issues:" -ForegroundColor Yellow
        Write-Host "- Incorrect SFTP credentials" -ForegroundColor Gray
        Write-Host "- Network/firewall blocking connection" -ForegroundColor Gray
        Write-Host "- Invalid remote path" -ForegroundColor Gray
        Write-Host ""
    }
} catch {
    Write-Host ""
    Write-Host "ERROR: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host ""
} finally {
    # Clean up temp file and sensitive data
    if (Test-Path $tempScript) {
        Remove-Item $tempScript -Force
    }
    $plainPassword = $null
}

pause
