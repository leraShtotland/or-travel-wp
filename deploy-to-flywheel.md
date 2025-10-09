# Deploying to Flywheel Production Site

## Problem
Your code is in GitHub and on your local site, but not on the production Flywheel site (https://orhorvitztravel.flywheelsites.com/).

## Solution Options

### Option 1: Manual SFTP Deployment (Immediate Solution)

1. **Get SFTP Credentials from Flywheel:**
   - Log into your Flywheel dashboard
   - Go to your site: orhorvitztravel
   - Click on "Connect" → "SFTP"
   - Note your credentials:
     - Host: [your-host].flywheelsites.com
     - Username: [your-username]
     - Password: [your-password]
     - Port: 22

2. **Upload Using FileZilla or WinSCP:**
   - Download FileZilla: https://filezilla-project.org/
   - Connect using your SFTP credentials
   - Navigate to the remote `/wp-content/` directory
   - Upload these folders from your local site:
     ```
     wp-content/themes/or-travel-child/
     wp-content/plugins/or-agent-widget/
     wp-content/plugins/or-site-setup/
     ```

3. **Activate the Theme:**
   - Log into WordPress admin: https://orhorvitztravel.flywheelsites.com/wp-admin
   - Go to Appearance → Themes
   - Activate "OR Travel Child" theme

### Option 2: Git Deployment with Flywheel (Recommended)

1. **Enable Git Push in Flywheel:**
   - Log into Flywheel dashboard
   - Go to your site settings
   - Look for "Git Push" or "Deployments" section
   - If available, enable Git deployments
   - Add your GitHub repository URL

2. **Set up Deploy Key:**
   - Flywheel will provide a deploy key
   - Add this to your GitHub repository:
     - Go to https://github.com/leraShtotland/or-travel-wp/settings/keys
     - Click "Add deploy key"
     - Paste the key from Flywheel

### Option 3: GitHub Actions Deployment (Automated)

Create `.github/workflows/deploy.yml` in your repository:

```yaml
name: Deploy to Flywheel

on:
  push:
    branches: [ master ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Deploy to Flywheel via SFTP
      uses: SamKirkland/FTP-Deploy-Action@4.3.0
      with:
        server: ${{ secrets.FTP_SERVER }}
        username: ${{ secrets.FTP_USERNAME }}
        password: ${{ secrets.FTP_PASSWORD }}
        port: 22
        protocol: sftp
        local-dir: ./wp-content/
        server-dir: /wp-content/
```

Then add secrets to your GitHub repository:
- Go to Settings → Secrets → Actions
- Add: FTP_SERVER, FTP_USERNAME, FTP_PASSWORD

## Quick Manual Deployment Script

If you have SSH access to Flywheel, you can use this script:

```bash
#!/bin/bash
# deploy.sh - Deploy to Flywheel

FLYWHEEL_HOST="your-host.flywheelsites.com"
FLYWHEEL_USER="your-username"
REMOTE_PATH="/path/to/wordpress/wp-content"

# Deploy themes
rsync -avz --delete \
  ./wp-content/themes/or-travel-child/ \
  $FLYWHEEL_USER@$FLYWHEEL_HOST:$REMOTE_PATH/themes/or-travel-child/

# Deploy plugins
rsync -avz --delete \
  ./wp-content/plugins/or-agent-widget/ \
  $FLYWHEEL_USER@$FLYWHEEL_HOST:$REMOTE_PATH/plugins/or-agent-widget/

rsync -avz --delete \
  ./wp-content/plugins/or-site-setup/ \
  $FLYWHEEL_USER@$FLYWHEEL_HOST:$REMOTE_PATH/plugins/or-site-setup/

echo "Deployment complete!"
```

## After Deployment

1. **Clear Cache:**
   - In Flywheel dashboard, clear the site cache
   - Clear browser cache

2. **Activate Theme & Plugins:**
   - Go to https://orhorvitztravel.flywheelsites.com/wp-admin
   - Activate the OR Travel Child theme
   - Activate the custom plugins if needed

3. **Test the Site:**
   - Visit https://orhorvitztravel.flywheelsites.com/
   - Verify the theme is working
   - Check that all functionality is operational

## Important Notes

- Always backup the production site before deploying
- Test changes locally first
- Consider using a staging environment
- The Astra parent theme must be installed on production

## Need Help?

Contact Flywheel support for:
- Enabling Git deployments
- Getting SFTP credentials
- Setting up staging environments
