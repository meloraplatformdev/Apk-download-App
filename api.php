<?php
session_start();
header('Content-Type: application/json');

// Storage setup
define('APP_NAME', 'APK SZ Store & Developer Console');
define('STORAGE_DIR', __DIR__ . '/data');

// Create storage directory if needed
if (!file_exists(STORAGE_DIR)) {
    mkdir(STORAGE_DIR, 0755, true);
}

$apps_file = STORAGE_DIR . '/apps.json';
$slides_file = STORAGE_DIR . '/slides.json';
$categories_file = STORAGE_DIR . '/categories.json';
$settings_file = STORAGE_DIR . '/settings.json';

// Get request method and action
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Response helper
function response($status, $message = '', $data = []) {
    http_response_code($status);
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Load all data
function loadAllData() {
    global $apps_file, $slides_file, $categories_file, $settings_file;
    
    return [
        'apps' => file_exists($apps_file) ? json_decode(file_get_contents($apps_file), true) : [],
        'slides' => file_exists($slides_file) ? json_decode(file_get_contents($slides_file), true) : [],
        'categories' => file_exists($categories_file) ? json_decode(file_get_contents($categories_file), true) : [],
        'settings' => file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : []
    ];
}

// Save all data
function saveAllData($data) {
    global $apps_file, $slides_file, $categories_file, $settings_file;
    
    file_put_contents($apps_file, json_encode($data['apps'], JSON_PRETTY_PRINT));
    file_put_contents($slides_file, json_encode($data['slides'], JSON_PRETTY_PRINT));
    file_put_contents($categories_file, json_encode($data['categories'], JSON_PRETTY_PRINT));
    file_put_contents($settings_file, json_encode($data['settings'], JSON_PRETTY_PRINT));
}

// Routing
switch ($action) {
    case 'get_all':
        $data = loadAllData();
        response(200, 'Data loaded successfully', $data);
        break;
    
    case 'add_app':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        
        $app = [
            'id' => 'app_' . time(),
            'name' => $input['name'] ?? '',
            'n' => $input['name'] ?? '',
            'package' => $input['package'] ?? '',
            'icon' => $input['icon'] ?? '',
            'i' => $input['icon'] ?? '',
            'developer' => $input['developer'] ?? '',
            'd' => $input['developer'] ?? '',
            'category' => $input['category'] ?? '',
            'c' => $input['category'] ?? '',
            'version' => $input['version'] ?? '1.0',
            'v' => $input['version'] ?? '1.0',
            'size' => $input['size'] ?? '25 MB',
            'apkName' => $input['apkName'] ?? 'release.apk',
            'desc' => $input['desc'] ?? '',
            'fullDesc' => $input['fullDesc'] ?? '',
            'status' => $input['status'] ?? 'Available'
        ];
        
        $data['apps'][] = $app;
        saveAllData($data);
        response(201, 'App added successfully', ['app' => $app]);
        break;
    
    case 'update_app':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        $id = $input['id'] ?? null;
        
        if (!$id) response(400, 'App ID required');
        
        foreach ($data['apps'] as &$app) {
            if ($app['id'] === $id) {
                $app = array_merge($app, $input);
                saveAllData($data);
                response(200, 'App updated successfully', ['app' => $app]);
            }
        }
        
        response(404, 'App not found');
        break;
    
    case 'delete_app':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        $id = $input['id'] ?? null;
        
        if (!$id) response(400, 'App ID required');
        
        foreach ($data['apps'] as $key => $app) {
            if ($app['id'] === $id) {
                unset($data['apps'][$key]);
                $data['apps'] = array_values($data['apps']);
                saveAllData($data);
                response(200, 'App deleted successfully');
            }
        }
        
        response(404, 'App not found');
        break;
    
    case 'add_banner':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        
        $banner = [
            'id' => 's_' . time(),
            'tag' => $input['tag'] ?? 'Featured',
            't' => $input['t'] ?? 'Promo',
            'p' => $input['p'] ?? 'Description',
            'g' => $input['g'] ?? 'linear-gradient(135deg, #667eea, #764ba2)'
        ];
        
        $data['slides'][] = $banner;
        saveAllData($data);
        response(201, 'Banner added successfully', ['banner' => $banner]);
        break;
    
    case 'delete_banner':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        $id = $input['id'] ?? null;
        
        if (!$id) response(400, 'Banner ID required');
        
        foreach ($data['slides'] as $key => $slide) {
            if ($slide['id'] === $id) {
                unset($data['slides'][$key]);
                $data['slides'] = array_values($data['slides']);
                saveAllData($data);
                response(200, 'Banner deleted successfully');
            }
        }
        
        response(404, 'Banner not found');
        break;
    
    case 'add_category':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        $category = $input['category'] ?? null;
        
        if (!$category) response(400, 'Category name required');
        if (in_array($category, $data['categories'])) response(400, 'Category already exists');
        
        $data['categories'][] = $category;
        saveAllData($data);
        response(201, 'Category added successfully');
        break;
    
    case 'delete_category':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        $category = $input['category'] ?? null;
        
        if (!$category) response(400, 'Category name required');
        
        $key = array_search($category, $data['categories']);
        if ($key !== false) {
            unset($data['categories'][$key]);
            $data['categories'] = array_values($data['categories']);
            saveAllData($data);
            response(200, 'Category deleted successfully');
        }
        
        response(404, 'Category not found');
        break;
    
    case 'update_settings':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $data = loadAllData();
        
        $data['settings'] = array_merge($data['settings'], $input);
        saveAllData($data);
        response(200, 'Settings updated successfully', ['settings' => $data['settings']]);
        break;
    
    case 'export':
        $data = loadAllData();
        response(200, 'Data export', $data);
        break;
    
    case 'import':
        if ($method !== 'POST') response(405, 'Method not allowed');
        
        $input = json_decode(file_get_contents('php://input'), true);
        saveAllData($input);
        response(200, 'Data imported successfully');
        break;
    
    default:
        response(400, 'Invalid action');
}
?>
