# Local ↔ Flywheel Workflow

This guide explains how to keep the production Flywheel site at `https://orhorvitztravel.flywheelsites.com/` in sync with the
WordPress theme stored in this repository. The workflow uses the [Local](https://localwp.com/) desktop app as the bridge between
Flywheel hosting and your VS Code development environment.

## Overview

1. Clone this repository locally.
2. Import or create a Local site that is connected to Flywheel.
3. Replace the Local site's `wp-content` with the version from this repository.
4. Develop using VS Code with the cloned files.
5. Push theme changes back to GitHub and deploy them to Flywheel through Local.

The goal is to ensure that the production site always reflects the theme stored in Git while letting you iterate locally with
standard development tooling.

## Prerequisites

- Access to the Flywheel account that hosts the production site.
- [Local by Flywheel](https://localwp.com/) installed on your machine and connected to your Flywheel account.
- Git installed and configured with access to this repository.
- VS Code (or another editor) configured for WordPress/PHP development.

## 1. Clone the repository

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

## 3. Replace Local's `wp-content` with the repository

1. Stop the site inside Local to avoid file locking.
2. Rename the Local-generated `wp-content` directory to keep a backup:

   ```bash
   mv "~/Local Sites/orhorvitztravel/app/public/wp-content" \
      "~/Local Sites/orhorvitztravel/app/public/wp-content.backup"
   ```

3. Create a symlink from the repository's `wp-content` to the Local site so both Local and VS Code use the same files:

   ```bash
   ln -s "$PWD/wp-content" "~/Local Sites/orhorvitztravel/app/public/wp-content"
   ```

4. Restart the site inside Local. WordPress now loads the theme files tracked in Git.

If you prefer not to use symlinks, you can copy the repository's `wp-content` directory into the Local site whenever you need to
update it. Symlinks ensure that saving in VS Code immediately updates the Local environment.

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

3. Deploy to Flywheel through Local:
   - In Local, open the site and click **Push to Flywheel**.
   - Confirm that you want to deploy the files and database if needed.
   - Local uploads the theme to Flywheel, making the production site match your repository.

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
