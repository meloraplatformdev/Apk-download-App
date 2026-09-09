<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
define('APP_NAME', 'APK SZ Store & Developer Console');
define('APP_VERSION', '1.0.0');
define('STORAGE_DIR', __DIR__ . '/data');

// Create storage directory if it doesn't exist
if (!file_exists(STORAGE_DIR)) {
    mkdir(STORAGE_DIR, 0755, true);
}

// Initialize local storage files
$apps_file = STORAGE_DIR . '/apps.json';
$slides_file = STORAGE_DIR . '/slides.json';
$categories_file = STORAGE_DIR . '/categories.json';
$settings_file = STORAGE_DIR . '/settings.json';

// Default data
$default_apps = [];
$default_slides = [
    ['id' => 's_1', 'tag' => 'Featured', 't' => 'Welcome to APK SZ Store', 'p' => 'Download the best Android apps', 'g' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)']
];
$default_categories = ['Games', 'Productivity', 'Social', 'Photography', 'Music', 'News'];
$default_settings = [
    'telegram' => 'https://t.me/',
    'youtube' => 'https://youtube.com/',
    'notice' => 'Welcome to APK SZ Store - Safe Android App Market',
    'privacy' => 'Your privacy is important to us. We respect your data and follow all regulations.'
];

// Initialize files
if (!file_exists($apps_file)) file_put_contents($apps_file, json_encode($default_apps));
if (!file_exists($slides_file)) file_put_contents($slides_file, json_encode($default_slides));
if (!file_exists($categories_file)) file_put_contents($categories_file, json_encode($default_categories));
if (!file_exists($settings_file)) file_put_contents($settings_file, json_encode($default_settings));

// Load data
$APPS = json_decode(file_get_contents($apps_file), true) ?: [];
$SLIDES = json_decode(file_get_contents($slides_file), true) ?: $default_slides;
$CATS = json_decode(file_get_contents($categories_file), true) ?: $default_categories;
$SETTINGS = json_decode(file_get_contents($settings_file), true) ?: $default_settings;

// Get app share URL
$share_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="<?php echo $SETTINGS['notice']; ?>">
  <meta name="theme-color" content="#2563eb">
  <meta property="og:title" content="<?php echo APP_NAME; ?>">
  <meta property="og:description" content="<?php echo $SETTINGS['notice']; ?>">
  <meta property="og:image" content="https://i.ibb.co.com/svHF8kCY/file-000000001d64820880cdac1e1065928f.png">
  <title><?php echo APP_NAME; ?></title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Inter Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/style.css">
</head>
<body oncontextmenu="return false;">

<!-- FULLSCREEN SCREENSHOT LIGHTBOX -->
<div id="lightboxModal" class="lightbox-modal hidden" onclick="closeLightbox()">
  <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white bg-white/20 hover:bg-white/30 w-9 h-9 rounded-full flex items-center justify-center text-sm">✕</button>
  <img id="lightboxImg" src="" alt="Fullscreen Screenshot" onclick="event.stopPropagation()">
</div>

<!-- SHARE MODAL -->
<div id="shareModal" class="fixed inset-0 bg-black/50 z-200 hidden flex items-end">
  <div class="w-full bg-white dark:bg-slate-900 rounded-t-3xl p-6 animate-slideUp">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-bold">Share App</h3>
      <button onclick="closeShareModal()" class="text-2xl">✕</button>
    </div>
    <div id="shareOptions" class="grid grid-cols-3 gap-4 mb-6">
      <div onclick="shareToApp('whatsapp')" class="flex flex-col items-center gap-2 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white text-xl"><i class="fa-brands fa-whatsapp"></i></div>
        <span class="text-xs font-semibold">WhatsApp</span>
      </div>
      <div onclick="shareToApp('telegram')" class="flex flex-col items-center gap-2 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl"><i class="fa-brands fa-telegram"></i></div>
        <span class="text-xs font-semibold">Telegram</span>
      </div>
      <div onclick="shareToApp('facebook')" class="flex flex-col items-center gap-2 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl"><i class="fa-brands fa-facebook"></i></div>
        <span class="text-xs font-semibold">Facebook</span>
      </div>
      <div onclick="shareToApp('twitter')" class="flex flex-col items-center gap-2 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center text-white text-xl"><i class="fa-brands fa-twitter"></i></div>
        <span class="text-xs font-semibold">Twitter</span>
      </div>
      <div onclick="shareToApp('copy')" class="flex flex-col items-center gap-2 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-slate-500 flex items-center justify-center text-white text-xl"><i class="fa-solid fa-copy"></i></div>
        <span class="text-xs font-semibold">Copy Link</span>
      </div>
      <div onclick="shareToApp('native')" class="flex flex-col items-center gap-2 cursor-pointer">
        <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white text-xl"><i class="fa-solid fa-share-nodes"></i></div>
        <span class="text-xs font-semibold">More</span>
      </div>
    </div>
  </div>
</div>

<!-- USER APP (APK SZ STORE) -->
<div id="userStoreApp" class="min-h-screen flex flex-col">

  <!-- DRAWER -->
  <div class="drawer-backdrop" id="drawerBackdrop" onclick="closeDrawer(event)">
    <div class="drawer" id="drawer">
      <div class="p-5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white flex items-center gap-3">
        <img src="https://i.ibb.co.com/svHF8kCY/file-000000001d64820880cdac1e1065928f.png" class="w-10 h-10 rounded-xl bg-white p-0.5 shadow">
        <div>
          <div class="text-sm font-extrabold" id="drawerStoreTitle"><?php echo APP_NAME; ?></div>
          <div class="text-[11px] text-blue-100 font-medium">Safe Android APK Market</div>
        </div>
      </div>
      <div class="flex-1 overflow-y-auto p-3 space-y-1 custom-scroll">
        <div class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider px-3 py-1">Navigation</div>
        <div class="drawer-item" onclick="drawerNav('home')"><i class="fa-solid fa-house text-blue-600 w-5"></i><span>Home</span></div>
        <div class="drawer-item" onclick="drawerNav('apps')"><i class="fa-solid fa-shapes text-blue-600 w-5"></i><span>Apps</span></div>
        <div class="drawer-item" onclick="drawerNav('games')"><i class="fa-solid fa-gamepad text-blue-600 w-5"></i><span>Games</span></div>
        <div class="drawer-item" onclick="drawerNav('browse')"><i class="fa-solid fa-layer-group text-blue-600 w-5"></i><span>Categories</span></div>
        <div class="drawer-item" onclick="showSavedApps()"><i class="fa-solid fa-heart text-rose-500 w-5"></i><span>Favorites</span></div>

        <div class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider px-3 pt-3 pb-1">Community & Support</div>
        <a id="drawerTelegramLink" class="drawer-item" href="<?php echo $SETTINGS['telegram']; ?>" target="_blank"><i class="fa-brands fa-telegram text-sky-500 w-5 text-base"></i><span>Telegram Channel</span></a>
        <a id="drawerYoutubeLink" class="drawer-item" href="<?php echo $SETTINGS['youtube']; ?>" target="_blank"><i class="fa-brands fa-youtube text-red-500 w-5 text-base"></i><span>YouTube Videos</span></a>

        <div class="text-[10px] font-extrabold uppercase text-slate-400 tracking-wider px-3 pt-3 pb-1">Preferences & Legal</div>
        <div class="drawer-item" onclick="toggleTheme()"><i class="fa-solid fa-moon text-blue-600 w-5"></i><span id="themeTxt">Dark Mode</span></div>
        <div class="drawer-item" onclick="openPrivacyModal()"><i class="fa-solid fa-shield-halved text-emerald-600 w-5"></i><span>Privacy Policy</span></div>
        <div class="drawer-item" onclick="requestAppModal()"><i class="fa-solid fa-paper-plane text-indigo-500 w-5"></i><span>Request App</span></div>
        <div class="drawer-item" onclick="drawerNav('admin')"><i class="fa-solid fa-crown text-amber-500 w-5"></i><span>Admin Console</span></div>
      </div>
    </div>
  </div>

  <!-- HEADER -->
  <header id="header">
    <div class="header-inner">
      <button class="icon-btn" onclick="openDrawer()"><i class="fa-solid fa-bars"></i></button>
      <input type="text" id="searchInput" placeholder="Search apps..." class="flex-1 bg-var(--bg) border border-var(--border) px-3 py-2 rounded-lg text-sm outline-none">
      <button class="icon-btn" onclick="toggleTheme()"><i class="fa-solid fa-circle-half-stroke"></i></button>
    </div>
    <div class="search-overlay" id="searchOverlay">
      <button class="icon-btn" onclick="closeSearch()"><i class="fa-solid fa-arrow-left"></i></button>
      <input type="text" id="searchInputOverlay" placeholder="Search..." class="flex-1 bg-transparent outline-none text-sm">
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="flex-1 overflow-y-auto custom-scroll">
    <div class="max-w-2xl mx-auto px-4 pb-20">

      <!-- HOME VIEW -->
      <div id="homeView" class="pt-4">
        <!-- HERO SLIDER -->
        <div class="hero-slider" id="heroSlider">
          <div class="slide active" id="slide_0"></div>
          <div class="dots" id="heroDots"></div>
        </div>

        <!-- CATEGORY CHIPS -->
        <div class="chips" id="categoryChips">
          <div class="chip active" onclick="filterCat('')">All</div>
        </div>

        <!-- APPS GRID -->
        <div class="h-scroll" id="appsGrid"></div>
      </div>

      <!-- APPS LIST VIEW -->
      <div id="appsView" class="pt-4 hidden">
        <h2 class="text-lg font-bold mb-3">All Apps</h2>
        <div id="appsList"></div>
      </div>

      <!-- GAMES VIEW -->
      <div id="gamesView" class="pt-4 hidden">
        <h2 class="text-lg font-bold mb-3">Games</h2>
        <div id="gamesList"></div>
      </div>

      <!-- BROWSE VIEW -->
      <div id="browseView" class="pt-4 hidden">
        <h2 class="text-lg font-bold mb-3">Categories</h2>
        <div id="categoriesList"></div>
      </div>

      <!-- ADMIN CONSOLE -->
      <div id="adminView" class="pt-4 hidden">
        <div class="mb-6 flex gap-2">
          <button onclick="adminTab('apps')" class="px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white" id="adminAppsBtn">Manage Apps</button>
          <button onclick="adminTab('banners')" class="px-4 py-2 rounded-lg font-semibold bg-slate-300" id="adminBannersBtn">Banners</button>
          <button onclick="adminTab('categories')" class="px-4 py-2 rounded-lg font-semibold bg-slate-300" id="adminCatsBtn">Categories</button>
          <button onclick="adminTab('settings')" class="px-4 py-2 rounded-lg font-semibold bg-slate-300" id="adminSettingsBtn">Settings</button>
        </div>

        <!-- MANAGE APPS TAB -->
        <div id="adminAppsTab" class="hidden">
          <h3 class="text-base font-bold mb-3">Add New App</h3>
          <form onsubmit="addAppForm(event)" class="space-y-3 bg-slate-100 dark:bg-slate-800 p-4 rounded-lg mb-6">
            <input type="text" id="app_name" placeholder="App Name" class="w-full px-3 py-2 rounded border" required>
            <input type="text" id="app_package" placeholder="Package Name (com.example.app)" class="w-full px-3 py-2 rounded border" required>
            <input type="text" id="app_icon" placeholder="Icon URL" class="w-full px-3 py-2 rounded border">
            <input type="text" id="app_developer" placeholder="Developer Name" class="w-full px-3 py-2 rounded border">
            <input type="text" id="app_category" placeholder="Category" class="w-full px-3 py-2 rounded border">
            <input type="text" id="app_version" placeholder="Version (e.g., 1.0)" class="w-full px-3 py-2 rounded border">
            <input type="text" id="app_size" placeholder="Size (e.g., 25 MB)" class="w-full px-3 py-2 rounded border">
            <input type="text" id="app_apkname" placeholder="APK File Name" class="w-full px-3 py-2 rounded border">
            <textarea id="app_desc" placeholder="Short Description" class="w-full px-3 py-2 rounded border" rows="2"></textarea>
            <textarea id="app_fulldesc" placeholder="Full Description" class="w-full px-3 py-2 rounded border" rows="3"></textarea>
            <select id="app_status" class="w-full px-3 py-2 rounded border">
              <option>Available</option>
              <option>Pre-Register</option>
              <option>Coming Soon</option>
            </select>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">Add App</button>
          </form>

          <h3 class="text-base font-bold mb-3">Apps List</h3>
          <div id="adminAppsList"></div>
        </div>

        <!-- BANNERS TAB -->
        <div id="adminBannersTab" class="hidden">
          <button onclick="openBannerModal()" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg font-bold">Add Banner</button>
          <div id="admBannerGrid" class="grid grid-cols-2 gap-3"></div>
        </div>

        <!-- CATEGORIES TAB -->
        <div id="adminCatsTab" class="hidden">
          <div class="mb-4 flex gap-2">
            <input type="text" id="newCatInput" placeholder="New Category" class="flex-1 px-3 py-2 rounded border">
            <button onclick="addCategory()" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold">Add</button>
          </div>
          <div id="admCategoryChips" class="flex flex-wrap gap-2"></div>
        </div>

        <!-- SETTINGS TAB -->
        <div id="adminSettingsTab" class="hidden">
          <div class="space-y-4">
            <div>
              <label class="text-sm font-bold">Telegram Link</label>
              <input type="text" id="set_telegram" placeholder="https://t.me/..." class="w-full px-3 py-2 rounded border mt-1">
            </div>
            <div>
              <label class="text-sm font-bold">YouTube Link</label>
              <input type="text" id="set_youtube" placeholder="https://youtube.com/..." class="w-full px-3 py-2 rounded border mt-1">
            </div>
            <div>
              <label class="text-sm font-bold">Store Notice</label>
              <textarea id="set_notice" placeholder="Store announcement..." class="w-full px-3 py-2 rounded border mt-1" rows="2"></textarea>
            </div>
            <div>
              <label class="text-sm font-bold">Privacy Policy</label>
              <textarea id="set_privacy" placeholder="Privacy policy content..." class="w-full px-3 py-2 rounded border mt-1" rows="4"></textarea>
            </div>
            <button onclick="saveSocialSettings()" class="w-full bg-green-600 text-white py-2 rounded-lg font-bold">Save Settings</button>
            <button onclick="savePrivacyPolicy()" class="w-full bg-green-600 text-white py-2 rounded-lg font-bold">Update Privacy Policy</button>
          </div>
        </div>
      </div>

    </div>
  </main>

</div>

<!-- VIEW MODAL -->
<div id="viewModal" class="detail hidden">
  <div class="max-w-2xl mx-auto p-4 pt-14">
    <button onclick="closeViewModal()" class="mb-6 px-3 py-2 bg-slate-200 dark:bg-slate-700 rounded-lg"><i class="fa-solid fa-arrow-left"></i></button>
    <div id="viewContent"></div>
    <button onclick="openShareModal()" class="dl-btn"><i class="fa-solid fa-share-nodes"></i> Share App</button>
    <button class="dl-btn"><i class="fa-solid fa-download"></i> Download</button>
  </div>
</div>

<!-- PRIVACY MODAL -->
<div id="privacyModal" class="detail hidden">
  <div class="max-w-2xl mx-auto p-4 pt-14">
    <button onclick="closePrivacyModal()" class="mb-6 px-3 py-2 bg-slate-200 dark:bg-slate-700 rounded-lg"><i class="fa-solid fa-arrow-left"></i></button>
    <h2 class="text-2xl font-bold mb-4">Privacy Policy</h2>
    <div id="privacyContent" class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed"></div>
  </div>
</div>

<!-- REQUEST APP MODAL -->
<div id="requestModal" class="detail hidden">
  <div class="max-w-2xl mx-auto p-4 pt-14">
    <button onclick="closeRequestModal()" class="mb-6 px-3 py-2 bg-slate-200 dark:bg-slate-700 rounded-lg"><i class="fa-solid fa-arrow-left"></i></button>
    <h2 class="text-2xl font-bold mb-4">Request an App</h2>
    <form onsubmit="submitRequest(event)" class="space-y-3">
      <input type="text" id="req_app_name" placeholder="App Name" class="w-full px-3 py-2 rounded border" required>
      <input type="text" id="req_app_package" placeholder="Package Name (Optional)" class="w-full px-3 py-2 rounded border">
      <textarea id="req_message" placeholder="Why do you want this app?" class="w-full px-3 py-2 rounded border" rows="4" required></textarea>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">Submit Request</button>
    </form>
  </div>
</div>

<!-- BANNER MODAL -->
<div id="bannerModal" class="detail hidden">
  <div class="max-w-2xl mx-auto p-4 pt-14">
    <button onclick="closeModal('bannerModal')" class="mb-6 px-3 py-2 bg-slate-200 dark:bg-slate-700 rounded-lg"><i class="fa-solid fa-arrow-left"></i></button>
    <h2 class="text-2xl font-bold mb-4">Add Banner Slide</h2>
    <div class="space-y-3">
      <input type="text" id="b_tag" placeholder="Banner Tag (e.g., Featured)" class="w-full px-3 py-2 rounded border">
      <input type="text" id="b_t" placeholder="Banner Title" class="w-full px-3 py-2 rounded border">
      <textarea id="b_p" placeholder="Banner Description" class="w-full px-3 py-2 rounded border" rows="2"></textarea>
      <input type="color" id="b_g" value="#667eea" class="w-full h-12 rounded cursor-pointer">
      <button onclick="saveBannerSlide()" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">Save Banner</button>
    </div>
  </div>
</div>

<!-- Data from PHP -->
<script>
  const APPS_DATA = <?php echo json_encode($APPS); ?>;
  const SLIDES_DATA = <?php echo json_encode($SLIDES); ?>;
  const CATS_DATA = <?php echo json_encode($CATS); ?>;
  const SETTINGS_DATA = <?php echo json_encode($SETTINGS); ?>;
  const SHARE_URL = '<?php echo $share_url; ?>';
</script>

<!-- Scripts -->
<script src="assets/app.js"></script>
</body>
</html>
