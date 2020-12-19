


    (function (window, $) {

        var dataTableParams = %2$s;

         dataTableParams['language'] = {
            url : 'http://localhost/excel/public/bap/js/trans/datatable/{{ app()->getLocale() }}.json'
        };

        window.LaravelDataTables = window.LaravelDataTables || {};
        window.LaravelDataTables["%1$s"] = $("#%1$s").DataTable(dataTableParams);

        // Filters in columns
        if(typeof(dataTableParams.columnFilters) !== 'undefined'){
            yadcf.init(window.LaravelDataTables["%1$s"] ,dataTableParams.columnFilters);
        }

    })(window, jQuery);
