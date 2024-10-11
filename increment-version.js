const fs = require('fs');
const path = require('path');

// Define the paths to the files
const packageJsonPath = path.resolve(__dirname, 'package.json');
const readmePath = path.resolve(__dirname, 'README.md');
const pluginFilePath = path.resolve(__dirname, 'rrze-hello-lenny.php');

// Function to increment the patch version
function incrementVersion(version) {
    const parts = version.split('.');
    parts[2] = parseInt(parts[2]) + 1;
    return parts.join('.');
}

// Function to update the version in a file
function updateVersionInFile(filePath, oldVersion, newVersion) {
    const content = fs.readFileSync(filePath, 'utf8');
    const updatedContent = content.replace(new RegExp(oldVersion, 'g'), newVersion);
    fs.writeFileSync(filePath, updatedContent, 'utf8');
}

// Read and update package.json
const packageJson = JSON.parse(fs.readFileSync(packageJsonPath, 'utf8'));
const oldVersion = packageJson.version;
const newVersion = incrementVersion(oldVersion);
packageJson.version = newVersion;
fs.writeFileSync(packageJsonPath, JSON.stringify(packageJson, null, 2), 'utf8');

// Update version in README.md
if (fs.existsSync(readmePath)) {
    updateVersionInFile(readmePath, oldVersion, newVersion);
}

// Update version in rrze-hello-lenny.php
if (fs.existsSync(pluginFilePath)) {
    updateVersionInFile(pluginFilePath, oldVersion, newVersion);
}

console.log(`Version updated from ${oldVersion} to ${newVersion}`);
