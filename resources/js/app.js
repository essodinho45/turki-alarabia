import './bootstrap';

import moment from 'moment';
console.log(moment().format());

import Pikaday from 'pikaday';
import 'pikaday/css/pikaday.css';

window.Pikaday = Pikaday;
