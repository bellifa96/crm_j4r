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
import * as $ from "jquery";
import * as bootstrap from "bootstrap";

// datatable
import 'datatables.net';
import 'datatables.net-bs5'
import './datatable_custom';

global.$ = global.jQuery = $;

import 'multiple-select/src/multiple-select';
import 'multiple-select/src/multiple-select.scss';
import 'multiple-select/dist/multiple-select.css';
import 'multiple-select/dist/multiple-select';
import 'intl-tel-input';
import 'intl-tel-input/build/css/intlTelInput.css'

import intlTelInput from 'intl-tel-input';

import select2 from 'select2';
import 'select2/dist/css/select2.css';
import 'jquery-ui-bundle';
import 'jquery-ui-bundle/jquery-ui.css';

$(function () {
    $(".datepicker").datepicker({
        closeText: 'Fermer',
        prevText: '&#x3c;Préc',
        nextText: 'Suiv&#x3e;',
        currentText: "Aujourd\'hui",
        monthNames: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun',
            'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        numberOfMonths: 1,
        showButtonPanel: true,
        changeYear: true
    });


    $('.tel-code').select2();


    $('.multi-select').multipleSelect();

    $('.table').DataTable({
        "oLanguage": {
            sSearch: "",
            searchPlaceholder: "Chercher"

        },
        language: {
            searchPlaceholder: "Chercher"
        }
    });


});

$(window).on('load', function () {
    $("#divLoader").css('display', 'none');
})

