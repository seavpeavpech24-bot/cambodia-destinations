<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DatabaseBackupController extends Controller
{
    protected $mysqlPath;
    protected $mysqldumpPath;

    public function __construct()
    {
        // Common MySQL installation paths on Windows
        $possiblePaths = [
            'C:\\xampp\\mysql\\bin\\',
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\',
            'C:\\Program Files (x86)\\MySQL\\MySQL Server 8.0\\bin\\',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\'
        ];

        // Try to find mysqldump in the system PATH first
        $mysqldumpPath = shell_exec('where mysqldump');
        if ($mysqldumpPath) {
            $this->mysqldumpPath = trim($mysqldumpPath);
            $this->mysqlPath = str_replace('mysqldump.exe', 'mysql.exe', $this->mysqldumpPath);
        } else {
            // If not found in PATH, try the common installation paths
            foreach ($possiblePaths as $path) {
                if (file_exists($path . 'mysqldump.exe')) {
                    $this->mysqldumpPath = $path . 'mysqldump.exe';
                    $this->mysqlPath = $path . 'mysql.exe';
                    break;
                }
            }
        }
    }

    public function index()
    {
        $backups = [];
        $backupPath = storage_path('app/backups');

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $files = glob($backupPath . '/*.sql');
        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => $this->formatSize(filesize($file)),
                'created_at' => date('Y-m-d H:i:s', filemtime($file))
            ];
        }

        // Sort backups by creation date, newest first
        usort($backups, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('admin.database-backup.index', compact('backups'));
    }

    public function create()
    {
        if (!$this->mysqldumpPath) {
            return redirect()->back()->with('error', 'mysqldump not found. Please ensure MySQL is installed and the path is correct.');
        }

        try {
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = $backupPath . '/' . $filename;

            // Get database credentials from config
            $dbName = Config::get('database.connections.mysql.database');
            $dbUser = Config::get('database.connections.mysql.username');
            $dbPass = Config::get('database.connections.mysql.password');
            $dbHost = Config::get('database.connections.mysql.host');

            // Build the mysqldump command
            $command = sprintf(
                '"%s" --host=%s --user=%s --password=%s %s > "%s"',
                $this->mysqldumpPath,
                escapeshellarg($dbHost),
                escapeshellarg($dbUser),
                escapeshellarg($dbPass),
                escapeshellarg($dbName),
                $filepath
            );

            // Execute the command
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('mysqldump command failed with return code: ' . $returnVar);
            }

            if (!file_exists($filepath) || filesize($filepath) === 0) {
                throw new \Exception('Backup file was not created or is empty');
            }

            return redirect()->back()->with('success', 'Database backup created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create backup: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);
        
        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'Backup file not found');
        }

        return response()->download($filepath);
    }

    public function restore(Request $request)
    {
        if (!$this->mysqlPath) {
            return redirect()->back()->with('error', 'mysql not found. Please ensure MySQL is installed and the path is correct.');
        }

        $request->validate([
            'backup_file' => 'required|file|mimes:sql'
        ]);

        try {
            $file = $request->file('backup_file');
            $tempPath = $file->getRealPath();

            // Get database credentials from config
            $dbName = Config::get('database.connections.mysql.database');
            $dbUser = Config::get('database.connections.mysql.username');
            $dbPass = Config::get('database.connections.mysql.password');
            $dbHost = Config::get('database.connections.mysql.host');

            // Build the mysql command
            $command = sprintf(
                '"%s" --host=%s --user=%s --password=%s %s < "%s"',
                $this->mysqlPath,
                escapeshellarg($dbHost),
                escapeshellarg($dbUser),
                escapeshellarg($dbPass),
                escapeshellarg($dbName),
                $tempPath
            );

            // Execute the command
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('mysql restore command failed with return code: ' . $returnVar);
            }

            return redirect()->back()->with('success', 'Database restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore database: ' . $e->getMessage());
        }
    }

    public function delete($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);
        
        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'Backup file not found');
        }

        unlink($filepath);
        return redirect()->back()->with('success', 'Backup deleted successfully');
    }

    protected function formatSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }
} 