<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'priority',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('priority')->orderBy('id');
    }

    public function scopeForProject(Builder $query, ?int $projectId): Builder
    {
        return $query->when(
            $projectId,
            fn (Builder $query) => $query->where('project_id', $projectId)
        );
    }

    protected function casts(): array
    {
        return [
            'project_id' => 'integer',
            'priority' => 'integer',
        ];
    }
}
