<?php

declare(strict_types=1);

namespace App\Actions\Task;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

final class CreateTaskAction
{
    /**
     * When priority is provided, shifts every task with priority >= N up by one,
     * then inserts the new row at N. Otherwise appends at max(priority) + 1.
     *
     * Priority is global across all projects (same list as drag-and-drop reorder).
     */
    public function handle(array $data): Task
    {
        $requestedPriority = $data['priority'] ?? null;
        $isInsertedAtPosition = $requestedPriority !== null && $requestedPriority !== '';

        return DB::transaction(function () use ($data, $requestedPriority, $isInsertedAtPosition): Task {
            $priority = $isInsertedAtPosition
                ? (int) $requestedPriority
                : $this->nextPriority();

            if ($isInsertedAtPosition) {
                Task::query()
                    ->where('priority', '>=', $priority)
                    ->increment('priority');
            }

            return Task::create([
                'project_id' => $data['project_id'],
                'name' => $data['name'],
                'priority' => $priority,
            ]);
        });
    }

    private function nextPriority(): int
    {
        $max = Task::query()->lockForUpdate()->max('priority');

        return (int) $max + 1;
    }
}
