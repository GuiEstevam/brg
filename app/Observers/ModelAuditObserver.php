<?php

namespace App\Observers;

use App\Services\AuditLogger;

trait ModelAuditObserver
{
    public static function bootModelAudit(): void
    {
        static::created(function ($model) {
            AuditLogger::log('created', $model, [], $model->getAttributes());
        });
        static::updated(function ($model) {
            AuditLogger::log('updated', $model, $model->getOriginal(), $model->getAttributes());
        });
        static::deleted(function ($model) {
            AuditLogger::log('deleted', $model, $model->getOriginal(), []);
        });
    }
}
