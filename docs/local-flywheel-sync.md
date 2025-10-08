# Local ↔ Flywheel Workflow

This guide explains how to keep the production Flywheel site at `https://orhorvitztravel.flywheelsites.com/` in sync with the
WordPress theme stored in this repository. The workflow uses the [Local](https://localwp.com/) desktop app as the bridge between
Flywheel hosting and your VS Code development environment.

## Overview

1. Clone this repository locally and open it in VS Code.
2. Pull the production Flywheel site down to your machine using Local.
3. Point the Local site at this repository's `wp-content` directory so Local, VS Code, and Git share the same files.
4. Develop and test inside Local; commit your changes to GitHub.
5. Push the verified theme back up to Flywheel directly from the Local app.

Following this flow guarantees that the production site always reflects the code stored in GitHub, while letting you iterate
locally with familiar tooling.

## Prerequisites

- Access to the Flywheel account that hosts the production site.
- [Local by Flywheel](https://localwp.com/) installed on your machine and connected to your Flywheel account.
- Git installed and configured with access to this repository.
- VS Code (or another editor) configured for WordPress/PHP development.

## 1. Clone the repository and open it in VS Code

```bash
cd ~/Projects
git clone https://github.com/leraShtotland/or-travel-wp.git
cd or-travel-wp
```

Open the project folder in VS Code to edit theme files:

```bash
code .
```

## 2. Pull the Flywheel site into Local

1. Launch **Local** and sign in to your Flywheel account.
2. In Local, click **Create** → **Connect to Flywheel** and choose `orhorvitztravel` from the list of available sites.
3. Select the latest backup or environment you want to mirror. Local will download the database and `wp-content` directory.
4. After provisioning completes, start the site inside Local. WordPress will be available at the Local-provided `.local` domain.

> **Tip:** Local creates a dedicated directory for the site on your machine (e.g., `~/Local Sites/orhorvitztravel/app/public`).

## 3. Point Local at the repository's `wp-content`

Run the helper script to wire the repository and Local together:

```bash
./bin/sync-local.sh --site-name orhorvitztravel --symlink
```

The script locates the Local site inside `~/Local Sites`, backs up the existing `wp-content`, and replaces it with a symlink that
points to the repository's copy. When you save files in VS Code they show up instantly in the Local environment.

If you prefer copying files instead of linking, drop the `--symlink` flag (or add `--pull` when you need to pull changes from
Local back into Git):

```bash
./bin/sync-local.sh --site-name orhorvitztravel --copy
```

After linking or copying, start the site again inside Local and visit the Local domain. You should immediately see the OR Travel
theme. If WordPress still shows another theme, go to **Appearance → Themes** and activate **OR Travel Child**.

> **Windows note:** The script falls back to copy mode if symlinks are unavailable. Run VS Code and Local as Administrator once if
> you want to use symlinks on Windows.

## 4. Develop with VS Code

- Use VS Code extensions such as **PHP Intelephense** and **WordPress Snippets** for better autocompletion.
- Configure debugging via [Xdebug](https://xdebug.org/) if needed. Local includes Xdebug—enable it from the Local UI under the
  **Tools** tab.
- Use `npm` or other build tooling from within the repository root if the theme includes frontend assets.

## 5. Sync changes back to Flywheel

1. Test your changes in the Local environment.
2. Commit and push the updated files to GitHub:

   ```bash
   git add wp-content
   git commit -m "Describe your change"
   git push origin main
   ```

3. Deploy to Flywheel. You have two options:
   - **From Local:** open the site in Local and click **Push to Flywheel**.
   - **From the repository:** run `./bin/deploy-to-flywheel.sh` (or `./bin/deploy-to-flywheel.sh --only-themes` if you only want
     to sync the `themes` directory). The script uses SFTP credentials stored in `.env.flywheel` to mirror the repository's
     `wp-content` to the Flywheel server, skipping uploads and cache directories by default.

4. After Local reports a successful deployment, spot-check the production site at
   `https://orhorvitztravel.flywheelsites.com/` to confirm the changes went live.

## 6. Keeping Flywheel up to date

- When teammates deploy from Local, remind them to pull the latest changes from Git before pushing to Flywheel.
- Periodically pull the production database down to Local to stay in sync with new content or configuration changes made via the
  WordPress admin on Flywheel.
- If Flywheel updates plugins or WordPress core automatically, capture those updates in Git by pulling from Flywheel via Local
  and committing the resulting changes.

## Troubleshooting

| Problem | Resolution |
| --- | --- |
| Local reports a symlink error on Windows | Run VS Code and Local as Administrator once to create the symlink, or copy files instead of linking. |
| The Flywheel site shows the default theme after deployment | Ensure `wp-content/themes/or-travel-child` exists and is activated in WordPress. Deploy again via Local if necessary. |
| Database changes are missing | Only files are tracked in Git. Use Local's **Pull from Flywheel**/**Push to Flywheel** to transfer the database when needed. |

Following this workflow keeps the production Flywheel site, Local development environment, and GitHub repository aligned.
