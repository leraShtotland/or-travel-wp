# Or Travel Child Theme - Usage Guide

## Overview
This child theme for Astra provides enhanced Hebrew/RTL support, an About Me page template, and a custom post type system for US travel articles with markdown support.

## Features

### 1. Enhanced RTL (Right-to-Left) Support for Hebrew
- Full RTL layout support
- Hebrew-optimized font stack (Heebo, Assistant, Rubik)
- RTL-aware navigation, lists, blockquotes, and buttons
- Mobile-responsive RTL support

### 2. About Me Page Template
- Custom page template with beautiful gradient header
- Profile image support (circular display)
- Optimized typography for longer content

#### How to Use:
1. Go to **Pages → Add New** in WordPress admin
2. Create a new page with your about content
3. In the **Page Attributes** sidebar, select **Template: About Me**
4. Set a **Featured Image** (this will be your profile photo)
5. Add your content
6. Publish the page

### 3. US Travel Articles System

#### Features:
- Custom post type for travel articles
- Markdown file upload support
- Category organization
- Beautiful card-based archive layout
- Featured images and excerpts
- Responsive grid display

#### How to Add Articles:

##### Method 1: Using Markdown Files
1. Go to **US Articles → Add New**
2. Enter the article title
3. In the sidebar, find the **Markdown File** box
4. Click **Upload Markdown File (.md)** and select your .md file
5. The content will be automatically imported from the markdown file
6. Set a **Featured Image** for the article
7. Select or create a **Category** (e.g., "New York", "California", "National Parks")
8. Click **Publish**

##### Method 2: Direct Content Entry
1. Go to **US Articles → Add New**
2. Enter the article title
3. Add content directly in the editor (supports markdown syntax)
4. Set a **Featured Image**
5. Select or create a **Category**
6. Add an excerpt (optional but recommended)
7. Click **Publish**

#### Markdown Syntax Supported:
```markdown
# Heading 1
## Heading 2
### Heading 3

**Bold text**
*Italic text*

[Link text](https://example.com)
![Image alt text](image-url.jpg)

- Unordered list item
- Another item

1. Ordered list item
2. Another item

> Blockquote

`inline code`

```
code block
```

---
Horizontal rule
```

#### Managing Article Categories:
1. Go to **US Articles → Categories**
2. Add new categories (e.g., "East Coast", "West Coast", "Midwest", "National Parks")
3. You can add descriptions and set parent categories
4. Categories will appear in the article filter navigation

#### Viewing Articles:
- **Archive page**: yoursite.com/us-articles/
- **Single article**: yoursite.com/us-article/article-name/
- **Category archive**: yoursite.com/article-category/category-name/

### 4. Image Management

#### For Articles:
1. **Featured Image**: Set this in the sidebar when editing an article (appears in cards and article header)
2. **Content Images**: 
   - In markdown: `![Alt text](image-url.jpg)`
   - Or upload through WordPress media library while editing
   - Images in content are automatically styled with rounded corners and shadows

#### Image Locations:
- Upload images through **Media → Add New**
- Or reference images from URLs in your markdown files
- Images in markdown files will be automatically formatted

### 5. Customization

#### Colors:
Edit the CSS variables in `style.css`:
```css
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --text-color: #111827;
    --border-radius: 12px;
    --box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}
```

#### Fonts:
The theme uses Hebrew-friendly fonts by default. To change, edit in `assets/css/child.css`:
```css
body {
    font-family: 'Heebo', 'Assistant', 'Rubik', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial Hebrew', Arial, sans-serif;
}
```

## File Structure

```
or-travel-child/
├── style.css                          # Main theme stylesheet
├── functions.php                      # Theme functions and custom post type
├── page-about.php                     # About Me page template
├── archive-us_article.php             # Articles archive template
├── single-us_article.php              # Single article template
├── taxonomy-article_category.php      # Category archive template
├── assets/
│   └── css/
│       └── child.css                  # Additional styles
└── includes/
    └── markdown-parser.php            # Markdown to HTML converter
```

## Tips

### For Best Results:
1. **Images**: Use high-quality images with 16:9 aspect ratio for featured images
2. **Excerpts**: Always write custom excerpts for better article previews
3. **Categories**: Keep categories organized and consistent
4. **Markdown**: Test your markdown files in a preview tool before uploading
5. **RTL**: Make sure your WordPress language is set to Hebrew for full RTL support

### Navigation Menu:
Add articles to your navigation:
1. Go to **Appearance → Menus**
2. Add custom links:
   - For all articles: `/us-articles/`
   - For specific categories: `/article-category/category-slug/`
3. Or add individual articles to the menu

## Troubleshooting

### Articles Not Showing:
1. Go to **Settings → Permalinks**
2. Click **Save Changes** (this refreshes the permalink structure)
3. Clear any caching plugins

### Markdown Not Converting:
- Ensure your file has the `.md` extension
- Check that the markdown syntax is correct
- Content with markdown symbols will be auto-converted on display

### RTL Not Working:
1. Go to **Settings → General**
2. Set **Site Language** to Hebrew
3. Clear browser cache

## Support

For customization requests or issues, contact your theme developer.

## Version
1.0.0
