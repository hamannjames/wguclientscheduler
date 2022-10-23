<div>
    <script>
        let min = new Date();
        let max = new Date();
        max.setMonth(min.getMonth() + 3);
        window.addEventListener('load', e => {
            Livewire.on('dateChanged', date => {
                alert(date);
            })
        })
    </script>
    <input
        id="date-picker"
        x-data
        x-ref="input"
        x-init="
            new Pikaday({ 
                field: $refs.input, 
                disableWeekends:true,
                minDate: min,
                maxDate: max,
                showDaysInNextAndPreviousMonths: true,
                enableSelectionDaysInNextAndPreviousMonths: true
            });
        "
        type="text"
        wire:model.lazy="date"
        wire:change="dateChange"
    >
</div>