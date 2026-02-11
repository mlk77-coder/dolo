# Landing Page - App Name Update & APK Download

## Changes Made

### App Name Changed to "دولو" (Dolo)
Updated all references from "تطبيق العروض والخصومات" to "تطبيق دولو" throughout the landing page and privacy policy.

### Files Updated:
1. **resources/views/landing/privacy.blade.php**
   - Page title: "سياسة الخصوصية - تطبيق دولو"
   - Header logo: "تطبيق دولو"
   - Footer copyright: "تطبيق دولو"
   - Privacy policy intro text: "تطبيق دولو"
   - Bottom disclaimer: "تطبيق دولو"

2. **resources/views/landing/index.blade.php**
   - Hero section: "تطبيق دولو"
   - Footer: "تطبيق دولو"
   - All sections use "دولو"
   - **NEW:** Added direct APK download button for Android

3. **app/Http/Controllers/LandingController.php**
   - **NEW:** Added `downloadApk()` method to handle APK downloads

4. **routes/web.php**
   - **NEW:** Added route `/download-apk` for APK downloads

### Download Buttons
Three download options are now available:

**1. App Store (iOS):**
```
https://apps.apple.com/app/dolo
```

**2. Google Play (Android):**
```
https://play.google.com/store/apps/details?id=com.dolo.app
```

**3. Direct APK Download (Android):**
```
Route: /download-apk
File Location: public/downloads/dolo-app.apk
```

### APK Download Setup

#### To Enable APK Downloads:
1. Build your Android app and generate the APK file
2. Rename the APK file to: `dolo-app.apk`
3. Upload it to: `public/downloads/dolo-app.apk`
4. The download button will automatically work

#### APK Button Features:
- Green gradient background (Android theme colors)
- Android icon
- Text: "تحميل مباشر - APK للأندرويد" (Direct Download - APK for Android)
- Appears in both hero section and CTA section
- Responsive design

#### Security Notes:
- APK files are ignored in git (see `public/downloads/.gitignore`)
- Only upload signed APK files ready for distribution
- Users will need to enable "Install from Unknown Sources" on their devices
- Keep the APK updated with the latest version

### Next Steps for User:
1. **Upload APK File:** Place your signed APK file at `public/downloads/dolo-app.apk`
2. **Update Store URLs:** Replace placeholder URLs with actual App Store and Google Play links
3. **Update Contact Info:** Update email, phone, and address in privacy policy
4. **Add Screenshots:** Replace mockup phone display with real app screenshots
5. **Update Social Media:** Add real social media links in the footer

### Routes:
- Homepage: `http://127.0.0.1:8000/`
- Privacy Policy: `http://127.0.0.1:8000/privacy`
- APK Download: `http://127.0.0.1:8000/download-apk`
- Admin Dashboard: `http://127.0.0.1:8000/login`

## Features:
- ✅ Arabic RTL layout
- ✅ Responsive design
- ✅ Three download options (App Store, Google Play, Direct APK)
- ✅ Privacy policy page in Arabic
- ✅ Gradient theme matching dashboard colors
- ✅ Animated elements and hover effects
- ✅ Footer with quick links and social media
- ✅ App name "دولو" throughout
- ✅ Direct APK download functionality
- ✅ Android-themed download button

## Technical Implementation:

### Controller Method:
```php
public function downloadApk()
{
    $apkPath = public_path('downloads/dolo-app.apk');
    
    if (!file_exists($apkPath)) {
        abort(404, 'APK file not found');
    }
    
    return response()->download($apkPath, 'dolo-app.apk', [
        'Content-Type' => 'application/vnd.android.package-archive',
    ]);
}
```

### Button Styling:
- Background: Green gradient (`from-green-500 to-emerald-600`)
- Hover effect: Darker gradient with scale transform
- Icon: Android logo (Font Awesome)
- Fully responsive on mobile and desktop
