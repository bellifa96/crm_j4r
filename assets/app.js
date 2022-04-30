/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/global.scss';
import './styles/buttons.scss';
import './styles/icons.scss';
import './styles/nav.scss';
import './styles/card.scss';
import './styles/form.scss';
import './styles/table.scss';
import './styles/pagination.scss'


import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// datatable
import 'datatables.net';
import 'datatables.net-bs5'
import './datatable_custom';

const $ = require('jquery');
global.$ = global.jQuery = $;

$(document).ready(function () {

    $('.table').DataTable();

});
