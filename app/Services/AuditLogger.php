<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    public static function record(string $action, Model $target, array $details = []): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'target_type' => class_basename($target),
            'target_id' => $target->getKey(),
            'ip_origin' => request()->ip(),
            'details' => $details,
        ]);
    }
}