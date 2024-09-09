import CodeFlask from 'codeflask';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Alpine.plugin(yourCustomPlugin);

Alpine.data('flask', (name, value, lang, readonly) => ({
    init() {
        const editor = new CodeFlask(this.$refs.editor, {
            language: lang,
            lineNumbers: true,
            readonly
        });

        if (value) {
            editor.updateCode(value);
        }


        this.$nextTick(() => {
            const textarea = this.$refs.editor.querySelector('textarea');

            textarea.classList.add('focus:ring-0')
            textarea.name = name;

            editor.onUpdate((value) => {
                textarea.value = value;
            })
        });
    }
}));

Livewire.start();