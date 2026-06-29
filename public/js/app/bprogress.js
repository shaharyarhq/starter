import { BProgress } from '@bprogress/core'
import '@bprogress/core/dist/index.css'

BProgress.configure({
    speed: 180,
    showSpinner: true,
})

document.addEventListener('livewire:init', () => {

    Livewire.hook('commit', ({ succeed, fail }) => {

        BProgress.start()

        succeed(() => {
            queueMicrotask(() => {
                BProgress.done()
            })
        })

        fail(() => {
            BProgress.done()
        })

    })

})

window.addEventListener('beforeunload', () => {
    BProgress.start()
})
