import './bootstrap';

import.meta.glob([
  '../images/**'
]);

import {livewire_hot_reload} from 'virtual:livewire-hot-reload'
livewire_hot_reload();

import Alpine from 'alpinejs';
import Pikaday from 'pikaday';

window.Alpine = Alpine;
window.Pikaday = Pikaday;

Alpine.start();

fetch('/api/user-timezone', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({tz: Intl.DateTimeFormat().resolvedOptions().timeZone})
}).then(
    res => res.text()
).then(res => {console.log(res)})
