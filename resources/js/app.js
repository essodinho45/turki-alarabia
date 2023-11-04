import './bootstrap';

import moment from 'moment';

import Pikaday from 'pikaday';
import 'pikaday/css/pikaday.css';

window.Pikaday = Pikaday;

window.Echo.private('user.' + window.UserId)
    .listen('NotifyUser', (e) => {
        console.log(e);
    });
