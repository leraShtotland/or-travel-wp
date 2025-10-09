# Flywheel SSH Setup Guide

## Your SSH Public Key (Created)

```
ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIAiigFaMel8/4JfcGLzh4FcdkDZGas3d5UEYOWoT3rfo elshtotl@flywheel
```

## Steps to Add SSH Key to Flywheel

### 1. Add SSH Key to Flywheel Dashboard

1. Go to: https://app.getflywheel.com/
2. Log in to your Flywheel account
3. Click on your profile icon (top right)
4. Go to **"Account Settings"** or **"SSH Keys"**
5. Click **"Add SSH Key"**
6. Give it a name: "Windows VS Code"
7. Paste the SSH key above (the entire line starting with ssh-ed25519)
8. Click **"Add Key"**

### 2. Wait a Few Minutes
- Flywheel needs a few minutes to propagate the SSH key

### 3. Test the Connection
Run this command to test:
```bash
ssh lerashtotland+orhorvitztravel@ssh.getflywheel.com "pwd"
```

## Once SSH is Working - Deploy Commands

### Upload Theme via SCP
```bash
# Upload or-travel-child theme
scp -r wp-content/themes/or-travel-child lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/themes/

# Upload Astra parent theme (if needed)
scp -r wp-content/themes/astra lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/themes/
```

### Upload Plugins via SCP
```bash
# Upload or-agent-widget plugin
scp -r wp-content/plugins/or-agent-widget lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/plugins/

# Upload or-site-setup plugin
scp -r wp-content/plugins/or-site-setup lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/plugins/
```

### Or Use Rsync (Better for Updates)
```bash
# Sync theme
rsync -avz --delete wp-content/themes/or-travel-child/ lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/themes/or-travel-child/

# Sync plugins
rsync -avz --delete wp-content/plugins/or-agent-widget/ lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/plugins/or-agent-widget/
rsync -avz --delete wp-content/plugins/or-site-setup/ lerashtotland+orhorvitztravel@ssh.getflywheel.com:~/sites/orhorvitztravel/wp-content/plugins/or-site-setup/
```

## Alternative: SFTP with Password

If you prefer to use SFTP with password instead of SSH key:

1. Get SFTP credentials from Flywheel dashboard
2. Use FileZilla or WinSCP to connect
3. Upload the folders manually

## After Upload - Activate in WordPress

1. Go to: https://orhorvitztravel.flywheelsites.com/wp-admin
2. **Themes:** Appearance → Themes → Activate "OR Travel Child"
3. **Plugins:** Plugins → Activate the custom plugins
4. **Cache:** Clear cache in Flywheel dashboard

## Troubleshooting

- **Permission denied:** Make sure you added the SSH key to Flywheel
- **Host key verification failed:** Type "yes" when prompted
- **Connection timeout:** Check your internet connection and firewall

## Your SSH Key Location
Your private key is stored at: `C:\Users\elshtotl\.ssh\id_ed25519`
Keep this file secure and never share it!
