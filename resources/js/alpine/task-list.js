import Sortable from 'sortablejs';

export default function registerTaskList(Alpine) {
    Alpine.data('taskList', (config) => ({
        reorderUrl: config.reorderUrl,
        csrfToken: config.csrfToken,
        canReorder: config.canReorder !== false,
        saving: false,
        error: null,
        sortable: null,
        lastOrder: [],

        init() {
            this.lastOrder = this.taskIdsInOrder();

            if (! this.canReorder) {
                return;
            }

            this.sortable = Sortable.create(this.$refs.list, {
                animation: 150,
                ghostClass: 'task-ghost',
                draggable: '[data-task-id]',
                filter: '.task-row-actions',
                preventOnFilter: true,
                onEnd: (evt) => {
                    if (evt.oldIndex === evt.newIndex) {
                        return;
                    }

                    this.saveOrder();
                },
            });
        },

        taskIdsInOrder() {
            return [...this.$refs.list.querySelectorAll('[data-task-id]')].map((row) =>
                Number(row.dataset.taskId),
            );
        },

        sameOrder(left, right) {
            return left.length === right.length
                && left.every((id, index) => id === right[index]);
        },

        updateBadges() {
            this.$refs.list.querySelectorAll('[data-task-id]').forEach((row, index) => {
                const badge = row.querySelector('[data-priority-badge]');
                if (badge) {
                    badge.textContent = String(index + 1);
                }
            });
        },

        async saveOrder() {
            const order = this.taskIdsInOrder();

            if (this.sameOrder(order, this.lastOrder)) {
                return;
            }

            this.saving = true;
            this.error = null;

            try {
                const response = await fetch(this.reorderUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: JSON.stringify({ task_ids: order }),
                });

                if (! response.ok) {
                    throw new Error('Could not save order.');
                }

                this.lastOrder = order;
                this.updateBadges();
            } catch (error) {
                this.error = error instanceof Error ? error.message : 'Could not save order.';
                window.setTimeout(() => window.location.reload(), 1500);
            } finally {
                this.saving = false;
            }
        },
    }));
}
