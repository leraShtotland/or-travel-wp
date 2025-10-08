# Installation & Setup Instructions

## Quick Start

### Step 1: Activate the Theme
The theme is already in place. If not already active:
1. Go to **Appearance → Themes** in WordPress admin
2. Activate **Or Travel Child** theme

### Step 2: Flush Permalinks (REQUIRED)
After activating the theme, you MUST flush permalinks:
1. Go to **Settings → Permalinks**
2. Simply click **Save Changes** (no need to change anything)
3. This registers the new custom post type URLs

### Step 3: Set Language to Hebrew (Optional but Recommended)
For full RTL support:
1. Go to **Settings → General**
2. Set **Site Language** to **עברית (Hebrew)**
3. Save changes

### Step 4: Create Your About Page
1. Go to **Pages → Add New**
2. Title: "About Me" or "אודות" (in Hebrew)
3. Add your content
4. **Page Attributes** → Template: Select **About Me**
5. Set a **Featured Image** (your profile photo)
6. Publish

### Step 5: Add Your First Article
1. Go to **US Articles → Add New**
2. Enter a title
3. Either:
   - Upload a markdown file using the **Markdown File** box in the sidebar
   - Or type/paste content directly in the editor
4. Set a **Featured Image**
5. Select or create a **Category**
6. Add an excerpt (optional but recommended)
7. Publish

### Step 6: Create Article Categories (Optional)
1. Go to **US Articles → Categories**
2. Add categories like:
   - East Coast
   - West Coast
   - National Parks
   - Cities
   - Road Trips
   - etc.

### Step 7: Add to Navigation Menu
1. Go to **Appearance → Menus**
2. Add custom links:
   - URL: `/us-articles/`
   - Link Text: "Travel Articles" or "מאמרי טיול"
3. Or add the About page
4. Save menu

## Verifying Installation

### Check These URLs Work:
- **Articles Archive**: `yoursite.com/us-articles/`
- **About Page**: `yoursite.com/about/` (or whatever slug you used)

If you see 404 errors, go back to **Step 2** and flush permalinks.

## File Locations

### Theme Files:
```
wp-content/themes/or-travel-child/
├── README.md (detailed usage guide)
├── INSTALLATION.md (this file)
├── sample-article.md (markdown template)
├── style.css
├── functions.php
├── page-about.php
├── archive-us_article.php
├── single-us_article.php
├── taxonomy-article_category.php
├── assets/css/child.css
└── includes/markdown-parser.php
```

### Sample Article:
A sample markdown file is included at:
`wp-content/themes/or-travel-child/sample-article.md`

You can use this as a template for your articles.

## Features Overview

✅ **Enhanced RTL/Hebrew Support**
- Full right-to-left layout
- Hebrew-optimized fonts
- RTL-aware components

✅ **About Me Page**
- Beautiful gradient header
- Profile image support
- Clean, readable layout

✅ **Article System**
- Custom post type for articles
- Markdown file upload
- Category organization
- Grid-based archive
- Beautiful single article layout

✅ **Image Support**
- Featured images for cards
- Content images from markdown
- Automatic styling

## Next Steps

1. ✅ Flush permalinks (Settings → Permalinks → Save)
2. Create your About page
3. Add article categories
4. Upload your first article with markdown
5. Add articles to your menu
6. Customize colors in `style.css` if needed

## Need Help?

Refer to the detailed **README.md** file for:
- Markdown syntax guide
- Detailed usage instructions
- Customization options
- Troubleshooting tips

## Common Issues

### "404 Not Found" on articles
**Solution**: Go to Settings → Permalinks and click Save Changes

### RTL not working
**Solution**: Set Site Language to Hebrew in Settings → General

### Markdown not converting
**Solution**: Ensure your file has `.md` extension and contains markdown syntax

### Featured images not showing
**Solution**: Make sure to set a Featured Image in the sidebar when editing

---

**Enjoy your new theme features!** 🎉
