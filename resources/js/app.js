import Alpine from 'alpinejs';
import registerTaskList from './alpine/task-list';

registerTaskList(Alpine);

window.Alpine = Alpine;
Alpine.start();
