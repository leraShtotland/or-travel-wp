# Local Development Guide

## 🎯 Your Local App is Now Using Local Code!

Your Local by Flywheel app is configured to use the **local codebase** from VS Code and GitHub, NOT the deployed Flywheel production code.

## ✅ What's Been Done

1. **Code Synced**: Latest code pulled from GitHub (2 commits updated)
2. **Git Repository**: Properly configured and tracking your local changes
3. **Local Environment**: WordPress configured for local development
4. **Database URLs**: Script created to ensure database uses local URLs

## 🔄 How It Works Now

### Your Development Workflow

```
┌─────────────────┐
│   VS Code       │  ← You edit code here
│   (Local Files) │
└────────┬────────┘
         │
         ↓
┌─────────────────┐
│   Git/GitHub    │  ← Version control
│   Repository    │
└────────┬────────┘
         │
         ↓
┌─────────────────┐
│   Local App     │  ← Displays your local code
│   (WordPress)   │     http://or-travel-local.local
└─────────────────┘

         ⚠️ SEPARATE ⚠️
         
┌─────────────────┐
│   Flywheel      │  ← Production site (separate)
│   Production    │     https://orhorvitztravel.flywheelsites.com
└─────────────────┘
```

### Current Setup

- **Local Code**: `c:\Users\elshtotl\Local Sites\or-travel-local\app\public`
- **Local URL**: `http://or-travel-local.local`
- **Production URL**: `https://orhorvitztravel.flywheelsites.com` (separate)
- **GitHub**: `https://github.com/leraShtotland/or-travel-wp`

## 🛠️ Final Setup Steps

### 1. Update Database URLs (IMPORTANT!)

Your database might still have production URLs. Run the SQL script:

**Option A: Using Local App (Recommended)**
1. Open Local app
2. Select your "or-travel-local" site
3. Click "Database" tab
4. Click "Open Adminer" (or "Open phpMyAdmin")
5. Click "SQL Command" or "SQL"
6. Copy and paste the content from `update-local-urls.sql`
7. Click "Execute"

**Option B: Using WP-CLI**
```bash
cd "c:\Users\elshtotl\Local Sites\or-travel-local\app\public"
wp search-replace 'https://orhorvitztravel.flywheelsites.com' 'http://or-travel-local.local' --all-tables
wp cache flush
```

### 2. Clear WordPress Cache

After updating URLs, clear the cache:
```bash
cd "c:\Users\elshtotl\Local Sites\or-travel-local\app\public"
wp cache flush
wp rewrite flush
```

Or visit: `http://or-travel-local.local/wp-admin/` and clear any caching plugins.

### 3. Restart Local Site

In Local app:
1. Stop the site
2. Start the site again
3. Visit `http://or-travel-local.local`

## 📝 Daily Development Workflow

### Making Changes

1. **Edit in VS Code** - Make your code changes
2. **Test Locally** - View changes at `http://or-travel-local.local`
3. **Commit to Git**:
   ```bash
   git add .
   git commit -m "Description of changes"
   git push origin master
   ```
4. **Deploy to Production** - When ready, use deployment scripts

### Key Files You're Working With

- **Theme Files**: `wp-content/themes/or-travel-child/`
- **Custom Code**: Your child theme files (functions.php, templates, etc.)
- **Assets**: CSS, JS in `wp-content/themes/or-travel-child/assets/`

## 🚀 Deployment to Production

When you want to push local changes to Flywheel production:

### Option 1: Using Deploy Scripts
```bash
# Windows PowerShell
.\deploy-sftp.ps1
```

### Option 2: Via GitHub
1. Push changes to GitHub: `git push origin master`
2. On Flywheel server, pull changes: `git pull origin master`

## 🔍 Troubleshooting

### Local Site Still Shows Production Content?

1. Check database URLs are correct:
   ```sql
   SELECT option_value FROM wp_options WHERE option_name IN ('siteurl', 'home');
   ```
   Should show: `http://or-travel-local.local`

2. Clear all caches:
   - WordPress cache
   - Browser cache (Ctrl+Shift+Delete)
   - Local app cache

3. Check wp-config.php has:
   ```php
   define( 'WP_ENVIRONMENT_TYPE', 'local' );
   ```

### Changes Not Appearing?

1. Make sure you saved the file in VS Code
2. Refresh browser (Ctrl+F5 for hard refresh)
3. Check file is in correct location
4. Clear WordPress cache

### Git Issues?

```bash
# Check current status
git status

# Pull latest changes
git pull origin master

# If conflicts, see what changed
git diff
```

## 📚 Important Notes

✅ **Your Local App Now Uses**:
- Local code from VS Code
- Local database
- Local file system
- Git-tracked changes

❌ **Your Local App Does NOT Use**:
- Flywheel production code
- Flywheel production database
- Deployed/live content

🔒 **Production Site is Separate**:
- Changes to local don't affect production
- Must explicitly deploy to update production
- Keep production backups before deploying

## 🎉 You're All Set!

Your Local WordPress app now displays the code you're editing in VS Code. Any changes you make in VS Code will immediately appear when you refresh your local site at `http://or-travel-local.local`.

**Need Help?**
- Check `sync-from-production.php` for sync instructions
- See `DEPLOYMENT-STEPS.md` for deployment help
- Review `README.md` for project overview
