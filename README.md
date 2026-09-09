# APK SZ Store - Developer Console

A modern, feature-rich Android APK store application with admin console built with PHP, HTML5, and JavaScript. Easily manage apps, banners, categories, and settings with a beautiful, responsive UI.

## 🎯 Features

- **User Store Interface**: Browse, search, and download Android APK files
- **App Management**: Add, edit, and delete apps with metadata
- **Banner Slides**: Create promotional slides with custom gradients
- **Category System**: Organize apps by categories
- **Share Functionality**: Share apps via WhatsApp, Telegram, Facebook, Twitter, and more
- **Dark Mode**: Toggle between light and dark themes
- **Favorites System**: Save favorite apps locally
- **Responsive Design**: Works perfectly on desktop and mobile devices
- **Admin Console**: Manage all aspects of the store
- **Local Storage**: Data persists in JSON files (no database required!)

## 📋 Requirements

- **PHP 7.0+** (for running locally or on shared hosting)
- **Modern Web Browser** (Chrome, Firefox, Safari, Edge)
- **Git** (for version control)

## 🚀 Quick Start

### Local Development

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/apk-sz-store.git
   cd apk-sz-store
   ```

2. **Create data directory**
   ```bash
   mkdir -p data
   chmod 755 data
   ```

3. **Run PHP built-in server**
   ```bash
   php -S localhost:8000
   ```

4. **Open in browser**
   ```
   http://localhost:8000
   ```

## 📦 GitHub Pages Deployment (Static Hosting)

Since GitHub Pages only supports static files, you have two options:

### Option 1: Use GitHub Pages with Netlify Functions
1. Push code to GitHub
2. Connect to Netlify and set up environment
3. Deploy with PHP support

### Option 2: Use GitHub Actions + Vercel
1. Push code to GitHub
2. Connect to Vercel
3. Select PHP as runtime

### Option 3: Deploy to Traditional Hosting (Recommended)

**Recommended Hosts:**
- **000webhost** (Free PHP hosting)
- **Heroku** (With buildpack for PHP)
- **Replit** (Free PHP environment)
- **PythonAnywhere** (Supports PHP via WSGI)
- **Hostinger** (Affordable shared hosting)

## 📂 Project Structure

```
apk-sz-store/
├── index.php              # Main application entry point
├── api.php                # Backend API endpoints
├── .htaccess              # Web server configuration
├── README.md              # This file
├── assets/
│   ├── app.js             # Main JavaScript logic
│   └── style.css          # Main stylesheet
├── data/                  # JSON data storage (auto-created)
│   ├── apps.json
│   ├── slides.json
│   ├── categories.json
│   └── settings.json
└── public/                # (Optional) Static assets folder
```

## 🔧 Configuration

### 1. Initial Setup

After first load, the app will automatically create:
- `data/apps.json` - App list
- `data/slides.json` - Banner slides
- `data/categories.json` - App categories
- `data/settings.json` - Store settings

### 2. Admin Console

Access the admin console:
1. Click the menu icon (☰)
2. Scroll to bottom
3. Click "Admin Console"

**Features:**
- Add/Edit/Delete apps
- Create promotional banners
- Manage categories
- Configure social links
- Edit privacy policy

## 📱 Using the Store

### For Users
1. Browse apps by category
2. Search for specific apps
3. View app details
4. Download apps
5. Share apps to social media
6. Add apps to favorites

### For Administrators
1. Go to Admin Console
2. Use tabs to manage:
   - **Apps**: Add new apps with details, versions, sizes
   - **Banners**: Create promotional slides
   - **Categories**: Add/remove app categories
   - **Settings**: Configure store info and social links

## 🌐 Deploying to Heroku

1. **Create Heroku account** at https://www.heroku.com

2. **Install Heroku CLI**
   ```bash
   # macOS
   brew tap heroku/brew && brew install heroku
   
   # Windows (use installer)
   # Linux
   curl https://cli-assets.heroku.com/install.sh | sh
   ```

3. **Create Procfile**
   ```bash
   echo 'web: vendor/bin/heroku-php-apache2' > Procfile
   ```

4. **Deploy**
   ```bash
   heroku login
   heroku create your-app-name
   git push heroku main
   ```

Your app will be live at: `https://your-app-name.herokuapp.com`

## 🌐 Deploying to Replit

1. Visit https://replit.com
2. Click "Create Repl"
3. Select "PHP" as language
4. Upload/import files from GitHub
5. Click "Run"

Your app will be live at: `https://your-replit-name.replit.dev`

## 🌐 Deploying to Traditional Hosting

### Via FTP/SFTP

1. Upload all files to `public_html` or `www` folder
2. Ensure `data/` folder has write permissions (755)
3. Access via your domain

### Via Control Panel

1. Upload ZIP file via cPanel/Plesk
2. Extract files
3. Set permissions on `data/` folder
4. Access via your domain

## 🔒 Security Considerations

1. **Permission Setting**
   ```bash
   chmod 755 data/
   chmod 644 data/*.json
   ```

2. **Protect Admin Console**
   - Change default admin access
   - Use environment variables for sensitive data

3. **Backup Data**
   - Regularly backup `data/` folder
   - Use version control (Git)

## 🎨 Customization

### Change Store Name
Edit `index.php` (line 8):
```php
define('APP_NAME', 'Your Store Name');
```

### Modify Colors
Edit `assets/style.css` (line 1-10):
```css
:root {
  --primary: #2563eb;
  --accent: #10b981;
  /* ... other colors ... */
}
```

### Add Custom Logo
Replace image URL in `index.php`:
```html
<img src="your-logo-url" class="w-10 h-10 rounded-xl bg-white p-0.5 shadow">
```

## 🐛 Troubleshooting

### Issue: 403 Forbidden Error
**Solution**: Check `data/` folder permissions
```bash
chmod 755 data/
chmod 644 data/*.json
```

### Issue: Cannot write to data folder
**Solution**: Set correct permissions on server
```bash
chmod 775 data/
```

### Issue: 404 Not Found on API calls
**Solution**: Ensure `.htaccess` is enabled on server
- Check if `mod_rewrite` is enabled
- Contact hosting provider if disabled

### Issue: Data not saving
**Solution**: Check if `data/` folder exists and is writable
- Manually create folder via FTP if needed
- Verify JSON files have correct format

## 📞 Support

For issues or questions:
1. Check the README thoroughly
2. Review the code comments
3. Contact your hosting provider
4. Open an issue on GitHub

## 📄 License

This project is open source and available under the MIT License.

## 🙏 Credits

Built with:
- Tailwind CSS
- Font Awesome Icons
- Google Fonts (Inter)
- PHP

## 🔄 Version History

**v1.0.0**
- Initial release
- Full app management
- Share functionality
- Admin console
- Dark mode support

---

**Happy hosting! 🚀**

Need help? Visit the GitHub repository for updates and documentation.
