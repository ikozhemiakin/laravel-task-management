<?php

declare(strict_types=1);

namespace App\Actions\Task;

use Illuminate\Support\Facades\DB;

final class ReorderTasksAction
{
    /**
     * @param  array<int>  $taskIds
     */
    public function handle(array $taskIds): void
    {
        if ($taskIds === []) {
            return;
        }
        $cases = [];
        $bindings = [];
        foreach ($taskIds as $index => $taskId) {
            $cases[] = 'WHEN id = ? THEN ?';
            $bindings[] = $taskId;
            $bindings[] = $index + 1;
        }
        $sql = sprintf(
            'UPDATE tasks SET priority = CASE %s END WHERE id IN (%s)',
            implode(' ', $cases),
            implode(', ', array_fill(0, count($taskIds), '?'))
        );

        DB::update($sql, [...$bindings, ...$taskIds]);
    }
}
