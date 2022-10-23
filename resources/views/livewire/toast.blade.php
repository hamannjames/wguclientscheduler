<div
    x-data="{
        isOpen: {{$show ? 'true' : 'false'}}
    }"
    x-show="isOpen"
    x-transition:enter="transition east-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-8"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-end="opacity-0 transform translate-x-8"
    x-init="
        setTimeout(() => {isOpen = false}, 5000)
        window.livewire.on('successNotification', () => {
            isOpen = true
            setTimeout(() => {isOpen = false}, 5000)
        })
        window.livewire.on('errorNotification', () => {
            isOpen = true
            setTimeout(() => {isOpen = false}, 5000)
        })
    "
    class="fixed right-0 bottom-0 bg-white rounded-xl shadow-lg border m-6 mb-24"
>
    <div class="stat-success px-6 py-4 border rounded-xl">
        {{$message}}
    </div>
</div>
