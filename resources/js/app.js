import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Alpine.plugin(yourCustomPlugin);

Livewire.start();

document.addEventListener('alpine:init', () => {
    // Add your AlpineJs code here...
});
