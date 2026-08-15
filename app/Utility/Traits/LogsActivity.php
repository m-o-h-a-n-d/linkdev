<?php

namespace App\Utility\Traits;

use App\Utility\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Boot the trait to listen for Eloquent events.
     */
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            $name = $model->name ?? $model->title ?? $model->id;
            ActivityLogger::log(
                action: 'CREATED',
                entityType: class_basename($model),
                entityId: $model->getKey(),
                description: sprintf('Created new %s: "%s"', class_basename($model), $name)
            );
        });

        static::updated(function (Model $model) {
            $dirtyFields = array_keys($model->getDirty());
            if (empty($dirtyFields) || (count($dirtyFields) === 1 && in_array('updated_at', $dirtyFields))) {
                return;
            }

            $name = $model->name ?? $model->title ?? $model->id;
            $changed = implode(', ', array_diff($dirtyFields, ['updated_at']));

            ActivityLogger::log(
                action: 'UPDATED',
                entityType: class_basename($model),
                entityId: $model->getKey(),
                description: sprintf('Updated %s "%s" (fields changed: %s)', class_basename($model), $name, $changed)
            );
        });

        static::deleted(function (Model $model) {
            $name = $model->name ?? $model->title ?? $model->id;
            ActivityLogger::log(
                action: 'DELETED',
                entityType: class_basename($model),
                entityId: $model->getKey(),
                description: sprintf('Deleted %s: "%s"', class_basename($model), $name)
            );
        });
    }
}
