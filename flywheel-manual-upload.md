# Manual Upload to Flywheel - Alternative Methods

Since SSH/SFTP command line isn't working, here are alternative ways to upload your files:

## Method 1: Flywheel Dashboard File Manager (Easiest)

1. **Go to Flywheel Dashboard**
   - https://app.getflywheel.com/
   - Select your site: **orhorvitztravel**

2. **Use File Manager**
   - Look for "File Manager" or "WP Admin" option
   - Navigate to `/wp-content/themes/`
   - Upload the `or-travel-child` folder from:
     ```
     c:\Users\elshtotl\Local Sites\or-travel-local\app\public\wp-content\themes\or-travel-child
     ```

3. **Upload Plugins**
   - Navigate to `/wp-content/plugins/`
   - Upload these folders:
     - `or-agent-widget`
     - `or-site-setup`

## Method 2: Using FileZilla (SFTP Client)

1. **Download FileZilla**
   - https://filezilla-project.org/download.php?platform=win64

2. **Get SFTP Credentials from Flywheel**
   - In Flywheel dashboard, go to your site
   - Click "Connect" → "SFTP"
   - You'll see:
     - **Host:** [something].flywheelsites.com
     - **Username:** [your-username]
     - **Password:** [your-password]
     - **Port:** 22

3. **Connect with FileZilla**
   - Open FileZilla
   - Enter the credentials from step 2
   - Click "Quickconnect"

4. **Upload Files**
   - Left side: Navigate to `c:\Users\elshtotl\Local Sites\or-travel-local\app\public\wp-content`
   - Right side: Navigate to `/sites/orhorvitztravel/wp-content`
   - Drag and drop:
     - `themes/or-travel-child` folder
     - `themes/astra` folder (if not there)
     - `plugins/or-agent-widget` folder
     - `plugins/or-site-setup` folder

## Method 3: Using WinSCP

1. **Download WinSCP**
   - https://winscp.net/eng/download.php

2. **Create New Connection**
   - File protocol: SFTP
   - Host name: [from Flywheel SFTP credentials]
   - Port: 22
   - User name: [from Flywheel]
   - Password: [from Flywheel]

3. **Upload the Folders**
   - Same as FileZilla method

## Method 4: Flywheel Local Connect (If Available)

1. **Check if you have Flywheel Local**
   - https://localwp.com/

2. **Use "Connect" Feature**
   - Some Flywheel accounts have a "Push to Flywheel" option
   - This can sync your local site directly

## After Uploading - Activate Everything

1. **Login to WordPress Admin**
   - https://orhorvitztravel.flywheelsites.com/wp-admin

2. **Activate Theme**
   - Go to Appearance → Themes
   - Find "OR Travel Child"
   - Click "Activate"

3. **Activate Plugins**
   - Go to Plugins
   - Activate:
     - OR Agent Widget
     - OR Site Setup

4. **Clear Cache**
   - In Flywheel dashboard, clear cache
   - Clear browser cache (Ctrl+Shift+Delete)

## Troubleshooting

- **Can't find SFTP credentials?** 
  - Contact Flywheel support
  - They may need to enable SFTP for your account

- **Files won't upload?**
  - Check file permissions
  - Try uploading in smaller batches
  - Ensure stable internet connection

- **Theme not showing after upload?**
  - Verify the folder structure is correct
  - Check that Astra parent theme is installed
  - Clear all caches

## Support Contacts

- **Flywheel Support:** https://getflywheel.com/support/
- **Live Chat:** Available in Flywheel dashboard
- **Email:** help@getflywheel.com
