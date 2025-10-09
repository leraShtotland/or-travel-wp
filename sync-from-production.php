<?php
/**
 * Sync Script for OR Travel Site
 * This script helps synchronize content from the production site
 * 
 * Usage: Run this script from the command line or browser to get instructions
 */

// Prevent direct access if not running from CLI
if (php_sapi_name() !== 'cli' && !isset($_GET['action'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>OR Travel - Sync Helper</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
            .info { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
            .warning { background: #fff3e0; padding: 15px; border-radius: 5px; margin: 10px 0; }
            .success { background: #e8f5e9; padding: 15px; border-radius: 5px; margin: 10px 0; }
            code { background: #f5f5f5; padding: 2px 5px; border-radius: 3px; }
            pre { background: #263238; color: #aed581; padding: 15px; border-radius: 5px; overflow-x: auto; }
        </style>
    </head>
    <body>
        <h1>🌍 OR Travel Site - Sync Helper</h1>
        
        <div class="info">
            <h2>Current Setup</h2>
            <ul>
                <li><strong>Local Site:</strong> <?php echo $_SERVER['HTTP_HOST'] ?? 'Local WordPress'; ?></li>
                <li><strong>Production Site:</strong> https://orhorvitztravel.flywheelsites.com/</li>
                <li><strong>GitHub Repository:</strong> https://github.com/leraShtotland/or-travel-wp</li>
            </ul>
        </div>

        <div class="warning">
            <h2>📋 Synchronization Instructions</h2>
            
            <h3>1. Sync Code from GitHub (Already Done ✅)</h3>
            <p>Your code is already synchronized with GitHub. To update in the future:</p>
            <pre>git pull origin master</pre>
            
            <h3>2. Export Database from Flywheel</h3>
            <ol>
                <li>Log into your Flywheel account</li>
                <li>Navigate to your site: orhorvitztravel</li>
                <li>Go to the "Database" tab</li>
                <li>Click "Export Database"</li>
                <li>Download the SQL file</li>
            </ol>
            
            <h3>3. Import Database to Local</h3>
            <p>Using Local app:</p>
            <ol>
                <li>Open Local app</li>
                <li>Select your "or-travel-local" site</li>
                <li>Go to "Database" tab</li>
                <li>Click "Import"</li>
                <li>Select the SQL file from Flywheel</li>
            </ol>
            
            <h3>4. Update URLs in Database</h3>
            <p>After importing, run this SQL in your local database:</p>
            <pre>
-- Update site URLs
UPDATE wp_options SET option_value = 'http://or-travel-local.local' 
WHERE option_name = 'siteurl' OR option_name = 'home';

-- Update content URLs
UPDATE wp_posts SET post_content = 
REPLACE(post_content, 'https://orhorvitztravel.flywheelsites.com', 'http://or-travel-local.local');

UPDATE wp_posts SET guid = 
REPLACE(guid, 'https://orhorvitztravel.flywheelsites.com', 'http://or-travel-local.local');

UPDATE wp_postmeta SET meta_value = 
REPLACE(meta_value, 'https://orhorvitztravel.flywheelsites.com', 'http://or-travel-local.local')
WHERE meta_value LIKE '%https://orhorvitztravel.flywheelsites.com%';
            </pre>
            
            <h3>5. Sync Media Files (Optional)</h3>
            <p>If you need media files from production:</p>
            <ol>
                <li>Download wp-content/uploads from Flywheel via SFTP</li>
                <li>Copy to your local wp-content/uploads folder</li>
            </ol>
        </div>

        <div class="success">
            <h2>✅ VS Code Integration</h2>
            <p>Your VS Code is already properly configured and connected to this local site!</p>
            <p>The workspace is tracking changes via Git to your GitHub repository.</p>
        </div>

        <div class="info">
            <h2>🔄 Workflow Summary</h2>
            <ol>
                <li><strong>Development:</strong> Make changes in VS Code on your local site</li>
                <li><strong>Version Control:</strong> Commit and push changes to GitHub</li>
                <li><strong>Deployment:</strong> Pull changes from GitHub to Flywheel production site</li>
            </ol>
        </div>

        <div class="warning">
            <h2>⚠️ Important Notes</h2>
            <ul>
                <li>Always backup before importing databases</li>
                <li>The local site URL should be: <code>http://or-travel-local.local</code></li>
                <li>Make sure to update URLs after database import</li>
                <li>Keep sensitive data (passwords, API keys) out of Git</li>
            </ul>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// CLI mode
echo "OR Travel Site - Sync Helper\n";
echo "=============================\n\n";
echo "This site is set up to sync with:\n";
echo "- Production: https://orhorvitztravel.flywheelsites.com/\n";
echo "- GitHub: https://github.com/leraShtotland/or-travel-wp\n\n";
echo "For detailed instructions, open this file in a browser.\n";
