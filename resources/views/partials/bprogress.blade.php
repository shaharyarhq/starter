<link rel="stylesheet"
      href="{{ asset('vendor/bprogress/bprogress.css') }}">

<script type="module">
import { BProgress } from "/vendor/bprogress/bprogress.js";

BProgress.configure({
    speed: 180,
    showSpinner: false,
});

document.addEventListener('livewire:init', () => {

    BProgress.configure({
        // speed: 180,
        showSpinner: true,
    });

   Livewire.hook('commit', ({
        component,
        commit,
        respond,
        succeed,
        fail
    }) => {
        BProgress.start();

        succeed(({
            snapshot,
            effect
        }) => {
            queueMicrotask(() => {
                BProgress.done();
                // BProgress.remove();
            });
        });
    });


});
</script>
