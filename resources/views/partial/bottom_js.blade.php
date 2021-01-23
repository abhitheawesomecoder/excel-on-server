
<!-- Scripts -->
{!! Packer::js([
    asset('/bap/plugins/jquery/jquery.min.js'),
    asset('/bap/plugins/jquery.i18n.js'),
    asset('/bap/js/trans/'.app()->getLocale().'.js'),

    asset('/bap/plugins/bootstrap/js/bootstrap.js'),
    asset('/bap/plugins/bootstrap-select/js/bootstrap-select.js'),
    asset('/bap/plugins/jquery-slimscroll/jquery.slimscroll.js'),
    asset('/bap/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'),
    asset('/bap/plugins/node-waves/waves.js'),
    asset('/bap/plugins/bootstrap-notify/bootstrap-notify.js'),
    asset('/bap/plugins/jquery.number.min.js'),
    asset('/bap/plugins/jquery-datatable/jquery.dataTables.js'),
    asset('/bap/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js'),
    asset('/bap/plugins/jquery-datatable/extensions/responsive/js/dataTables.responsive.js'),
    asset('/bap/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js'),
    asset('/bap/plugins/jquery-datatable/extensions/export/buttons.html5.min.js'),
    asset('/bap/plugins/jquery-datatable/extensions/export/buttons.print.min.js'),
    asset('/bap/plugins/jquery-datatable/extensions/export/jszip.min.js'),
    asset('/bap/plugins/jquery-datatable/extensions/export/pdfmake.min.js'),
    asset('/bap/plugins/jquery-datatable/extensions/export/vfs_fonts.js'),
    asset('/bap/plugins/offlinejs/offline.min.js'),
    asset('/bap/plugins/select2-4.0.3/dist/js/select2.full.min.js'),
    asset('/bap/plugins/bootstrap-fileinput/js/fileinput.min.js'),
    asset('/bap/plugins/momentjs/moment.js'),
    asset('/bap/plugins/momentjs/locale/'.app()->getLocale().'.js'),
    asset('/bap/plugins/bootstrap-daterangepicker/daterangepicker.js'),
    asset('/bap/plugins/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.min.js'),
    asset('/bap/plugins/jquery-comments/js/jquery.textcomplete.min.js'),
    asset('/bap/plugins/jquery-comments/js/jquery-comments.min.js'),
    asset('/bap/plugins/js.cookie.js'),
    asset('/bap/js/BapConfig.js'),
    asset('/bap/js/BapDatatable.js'),
    asset('/bap/js/BapPlatform.js'),
    asset('/bap/plugins/jquery-datatable/yadcf/jquery.dataTables.yadcf.js'),
    asset('/bap/plugins/jquery-jscroll/jquery.jscroll.min.js'),

    asset('/bap/js/admin.js'),
    asset('/bap/js/Common.js'),

    asset('/modules/notifications/js/BAP_Notifications.js'),

    asset('/vendor/todo/jquery.todoList.js')
    ],
    asset('/storage/cache/js/')
) !!}



