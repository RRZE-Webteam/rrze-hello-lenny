const fs = require('fs');
const path = require('path');

// Define the paths to the files
const packageJsonPath = path.resolve(__dirname, 'package.json');
const readmePath = path.resolve(__dirname, 'README.md');
const pluginFilePath = path.resolve(__dirname, 'rrze-hello-lenny.php');

// Function to increment the version based on the type
function incrementVersion(version, type) {
    const parts = version.split('.');
    if (type === 'minor') {
        parts[1] = parseInt(parts[1], 10) + 1;
        parts[2] = 0; // Reset patch version to 0 when incrementing minor version
    } else {
        parts[2] = parseInt(parts[2], 10) + 1; // Increment patch version
    }
    return parts.join('.');
}

// Function to update the version in a file
function updateVersionInFile(filePath, oldVersion, newVersion) {
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        const regex = new RegExp(oldVersion.replace(/\./g, '\\.'), 'g');
        if (!regex.test(content)) {
            console.warn(`Old version ${oldVersion} not found in ${filePath}.`);
            return;
        }
        content = content.replace(regex, newVersion);
        fs.writeFileSync(filePath, content, 'utf8');
    } catch (error) {
        console.error(`Failed to update version in ${filePath}: ${error.message}`);
    }
}

// Get the version increment type from the command line arguments
const incrementType = process.argv[2] || 'patch';

// Read and update package.json
let oldVersion;
let newVersion;
try {
    const packageJson = JSON.parse(fs.readFileSync(packageJsonPath, 'utf8'));
    oldVersion = packageJson.version;
    newVersion = incrementVersion(oldVersion, incrementType);
    packageJson.version = newVersion;
    fs.writeFileSync(packageJsonPath, JSON.stringify(packageJson, null, 2), 'utf8');
} catch (error) {
    console.error(`Failed to read or update package.json: ${error.message}`);
    process.exit(1);
}

// Update Stable tag in README.md
if (fs.existsSync(readmePath)) {
    updateVersionInFile(readmePath, `Stable tag: ${oldVersion}`, `Stable tag: ${newVersion}`);
}

// Update version in rrze-hello-lenny.php
if (fs.existsSync(pluginFilePath)) {
    updateVersionInFile(pluginFilePath, `Version: ${oldVersion}`, `Version: ${newVersion}`);
}

console.log(`Version updated from ${oldVersion} to ${newVersion}`);
