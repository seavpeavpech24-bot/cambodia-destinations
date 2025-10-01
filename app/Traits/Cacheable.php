<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait Cacheable
{
    /**
     * Clear all admin dashboard related caches
     */
    protected function clearAdminDashboardCache()
    {
        Cache::forget('admin_dashboard_counts');
        Cache::forget('admin_recent_activities');
    }

    /**
     * Clear specific model's cache
     */
    protected function clearModelCache($model)
    {
        $cacheKey = strtolower(class_basename($model)) . '_cache';
        Cache::forget($cacheKey);
    }

    /**
     * Clear all caches related to a specific model
     */
    protected function clearAllModelCaches()
    {
        $this->clearAdminDashboardCache();
        $this->clearModelCache($this->model);
    }
} 