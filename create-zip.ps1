Add-Type -Assembly System.IO.Compression.FileSystem

$source = "D:\Hermes Project\Web Redesign Rillatype\wp-content\themes\rillatype-v2"
$destination = "D:\Hermes Project\Web Redesign Rillatype\rillatype-v2.zip"

# Delete old zip
if (Test-Path $destination) {
    Remove-Item $destination -Force
}

# Create new zip
$zip = [IO.Compression.ZipFile]::Open($destination, 'Create')

# Get all files
$files = Get-ChildItem -Path $source -Recurse -File

foreach ($file in $files) {
    $relativePath = $file.FullName.Substring($source.Length + 1).Replace('\', '/')
    $entry = $zip.CreateEntry($relativePath)
    $writer = New-Object IO.StreamWriter($entry.Open())
    $reader = New-Object IO.StreamReader($file.FullName)
    $content = $reader.ReadToEnd()
    $reader.Close()
    $writer.Write($content)
    $writer.Close()
    Write-Host "Added: $relativePath"
}

$zip.Dispose()
Write-Host "`nZIP created at: $destination"
