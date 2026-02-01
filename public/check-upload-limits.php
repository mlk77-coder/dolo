<!DOCTYPE html>
<html>
<head>
    <title>PHP Upload Limits Check</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        .setting { padding: 15px; margin: 10px 0; background: #f9f9f9; border-left: 4px solid #4CAF50; border-radius: 4px; }
        .setting strong { color: #2196F3; display: inline-block; width: 200px; }
        .value { color: #333; font-weight: bold; }
        .good { color: #4CAF50; }
        .bad { color: #f44336; }
        .info { background: #E3F2FD; padding: 15px; border-radius: 5px; margin-top: 20px; border-left: 4px solid #2196F3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 PHP Upload Limits</h1>
        
        <div class="setting">
            <strong>upload_max_filesize:</strong>
            <span class="value <?php echo (ini_get('upload_max_filesize') == '100M') ? 'good' : 'bad'; ?>">
                <?php echo ini_get('upload_max_filesize'); ?>
            </span>
            <?php if(ini_get('upload_max_filesize') == '100M'): ?>
                ✅
            <?php else: ?>
                ❌ (Should be 100M)
            <?php endif; ?>
        </div>
        
        <div class="setting">
            <strong>post_max_size:</strong>
            <span class="value <?php echo (ini_get('post_max_size') == '120M') ? 'good' : 'bad'; ?>">
                <?php echo ini_get('post_max_size'); ?>
            </span>
            <?php if(ini_get('post_max_size') == '120M'): ?>
                ✅
            <?php else: ?>
                ❌ (Should be 120M)
            <?php endif; ?>
        </div>
        
        <div class="setting">
            <strong>memory_limit:</strong>
            <span class="value <?php echo (ini_get('memory_limit') == '256M') ? 'good' : 'bad'; ?>">
                <?php echo ini_get('memory_limit'); ?>
            </span>
            <?php if(ini_get('memory_limit') == '256M'): ?>
                ✅
            <?php else: ?>
                ❌ (Should be 256M)
            <?php endif; ?>
        </div>
        
        <div class="setting">
            <strong>max_execution_time:</strong>
            <span class="value">
                <?php echo ini_get('max_execution_time'); ?> seconds
            </span>
        </div>
        
        <div class="setting">
            <strong>max_input_time:</strong>
            <span class="value">
                <?php echo ini_get('max_input_time'); ?> seconds
            </span>
        </div>
        
        <div class="info">
            <strong>ℹ️ Status:</strong><br>
            <?php 
            $upload = ini_get('upload_max_filesize');
            $post = ini_get('post_max_size');
            
            if($upload == '100M' && $post == '120M'): 
            ?>
                <span class="good">✅ Settings are correct! You can now upload images up to 20MB and videos up to 100MB.</span>
            <?php else: ?>
                <span class="bad">❌ Settings are NOT correct. Please follow the instructions in UPLOAD_SIZE_FIX_INSTRUCTIONS.md</span>
            <?php endif; ?>
        </div>
        
        <div class="info" style="margin-top: 20px; border-left-color: #FF9800; background: #FFF3E0;">
            <strong>🔧 Next Steps:</strong><br>
            1. If settings are correct, delete this file: <code>public/check-upload-limits.php</code><br>
            2. Try uploading an image larger than 2MB in the deal form<br>
            3. If still failing, restart your web server (php artisan serve)
        </div>
    </div>
</body>
</html>
