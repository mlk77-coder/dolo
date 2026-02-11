# APK Downloads Folder

## Instructions

Place your Android APK file in this folder with the name: **dolo-app.apk**

### Steps:
1. Build your Android app and generate the APK file
2. Rename the APK file to: `dolo-app.apk`
3. Upload it to this folder: `public/downloads/dolo-app.apk`
4. The download button on the landing page will automatically serve this file

### File Location:
```
public/downloads/dolo-app.apk
```

### Download URL:
```
https://yourdomain.com/download-apk
```

### Notes:
- Make sure the APK file is signed and ready for distribution
- The file will be downloaded with the name "dolo-app.apk"
- Users will need to enable "Install from Unknown Sources" on their Android devices
- Consider adding a version number to the filename for updates (e.g., dolo-app-v1.0.0.apk)

### Security Considerations:
- Only upload APK files from trusted sources
- Keep the APK file updated with the latest version
- Consider adding a checksum or signature verification
- Monitor download logs for security purposes

### Alternative Approach:
If you want to host multiple versions, you can modify the controller to:
1. List available APK files
2. Allow users to choose which version to download
3. Automatically serve the latest version
