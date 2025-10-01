<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataManagementController extends Controller
{
    public function index()
    {
        $tables = DB::select('SHOW TABLES');
        $deletedData = [];
        
        foreach ($tables as $table) {
            $tableName = reset($table); // Get the table name from the result
            if (Schema::hasColumn($tableName, 'deleted_at')) {
                $count = DB::table($tableName)->whereNotNull('deleted_at')->count();
                if ($count > 0) {
                    // Get the first few records to determine available columns
                    $records = DB::table($tableName)
                        ->whereNotNull('deleted_at')
                        ->limit(5)
                        ->get();
                    
                    // Determine which columns to display
                    $displayColumns = [];
                    if (Schema::hasColumn($tableName, 'title')) {
                        $displayColumns[] = 'title';
                    } elseif (Schema::hasColumn($tableName, 'name')) {
                        $displayColumns[] = 'name';
                    } elseif (Schema::hasColumn($tableName, 'email')) {
                        $displayColumns[] = 'email';
                    }
                    
                    // Always include these columns
                    $displayColumns = array_merge(['id', 'deleted_at'], $displayColumns);
                    
                    $deletedData[$tableName] = [
                        'count' => $count,
                        'columns' => $displayColumns,
                        'records' => DB::table($tableName)
                            ->whereNotNull('deleted_at')
                            ->select($displayColumns)
                            ->get()
                    ];
                }
            }
        }
        
        return view('admin.data-management.index', compact('deletedData'));
    }

    public function restore($table, $id)
    {
        if (Schema::hasColumn($table, 'deleted_at')) {
            DB::table($table)
                ->where('id', $id)
                ->update(['deleted_at' => null]);
            
            return redirect()->back()->with('success', 'Record restored successfully');
        }
        
        return redirect()->back()->with('error', 'Invalid table or record');
    }

    public function permanentDelete($table, $id)
    {
        if (Schema::hasColumn($table, 'deleted_at')) {
            DB::table($table)
                ->where('id', $id)
                ->whereNotNull('deleted_at')
                ->delete();
            
            return redirect()->back()->with('success', 'Record permanently deleted');
        }
        
        return redirect()->back()->with('error', 'Invalid table or record');
    }
} 