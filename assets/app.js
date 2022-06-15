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

import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';

import "trumbowyg/dist/trumbowyg.min"
import icons from "trumbowyg/dist/ui/icons.svg"
import "trumbowyg/dist/ui/trumbowyg.min.css"
import "trumbowyg/plugins/base64/trumbowyg.base64";
import "trumbowyg/plugins/lineheight/trumbowyg.lineheight";
import "trumbowyg/plugins/colors/trumbowyg.colors";
import "trumbowyg/plugins/allowtagsfrompaste/trumbowyg.allowtagsfrompaste";
import "trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste";
import "trumbowyg/plugins/history/trumbowyg.history";
import "trumbowyg/plugins/indent/trumbowyg.indent";
import "trumbowyg/plugins/pasteimage/trumbowyg.pasteimage";
import "trumbowyg/plugins/table/trumbowyg.table";
import "trumbowyg/plugins/table/ui/sass/trumbowyg.table.scss"
import "trumbowyg/plugins/table/ui/icons/table.svg";
import "trumbowyg/plugins/table/ui/icons/table-delete.svg";
import "trumbowyg/plugins/table/ui/icons/col-delete.svg";
import "trumbowyg/plugins/table/ui/icons/col-left.svg";
import "trumbowyg/plugins/table/ui/icons/col-right.svg";
import "trumbowyg/plugins/table/ui/icons/row-delete.svg";
import "trumbowyg/plugins/table/ui/icons/row-above.svg";
import "trumbowyg/plugins/table/ui/icons/row-below.svg";
import "trumbowyg/plugins/resizimg/trumbowyg.resizimg";
import "trumbowyg/plugins/fontsize/trumbowyg.fontsize";
import "trumbowyg/plugins/fontsize/ui/icons/fontsize.svg";


import "trumbowyg/plugins/upload/trumbowyg.upload";


import "trumbowyg/plugins/emoji/trumbowyg.emoji";


$.trumbowyg.svgPath = icons
$.trumbowyg.svgAbsoluteUsePath = true;
$(function () {


    $('.editor').trumbowyg({
        btns: [
            ['viewHTML'],
            ['formatting'],
            'btnGrp-semantic',
            ['superscript', 'subscript'],
            ['fontsize'],
            ['link'],
            ['insertImage'],
            'btnGrp-justify',
            'btnGrp-lists',
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen'],
            "base64", 'foreColor',
            'backColor', 'emoji',
            'fontfamily',
            'highlight',
            ['historyUndo', 'historyRedo'],
            'indent', 'outdent',
            'lineheight',
            'preformatted',
            'specialChars',
            'table'
        ],
        plugins: {
            allowTagsFromPaste: {
                allowedTags: ['h1', 'h2', 'h3', 'h4', 'p', 'br']
            },
            resizimg: {
                minSize: 32,
                step: 4,
            },
            fontsize: {
                sizeList: [
                    '12px',
                    '14px',
                    '16px',
                    '18px',
                    '20px',
                    '24px',
                    '28px',
                ]
            }

        }
    });

    /*const editor = new EditorJS({

        holder: 'editorjs',

        tools: {
            header: {
                class: Header,
                inlineToolbar: ['link']
            },
            list: {
                class: List,
                inlineToolbar: true
            },
            image: {
                class: ImageTool,
            }
        },
        data: {}
    })*/

    var calendarEl = document.getElementById('calendar');


    if (calendarEl != null) {
        let calendar = new Calendar(calendarEl, {
            lang: 'fr',
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            }
        });
        calendar.render();
    }


    $('.checkbox,.radio').each(function () {
        $(this).checkboxradio();
    });

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
        changeYear: true,
    });


    $('.tel-code').select2();


    $('.multi-select').multipleSelect();

    $('.datatable').DataTable({
        "oLanguage": {
            sSearch: "",
            searchPlaceholder: "Chercher"

        },
        language: {
            searchPlaceholder: "Chercher"
        }
    });


})
;

$(window).on('load', function () {
    $("#divLoader").css('display', 'none');
})

