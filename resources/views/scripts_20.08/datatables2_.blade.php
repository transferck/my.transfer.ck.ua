
<script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>

<script>


    $('#departure_table').dataTable({
        "language":{
            "url": "/js/datatableLanguage.json"
        },
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "dom": 'T<"clear">lfrtip',
        "sPaginationType": "full_numbers",
        "bLengthChange": false,
        'aoColumnDefs': [{
            'bSortable': false,
            'searchable': false,
            'aTargets': ['no-search'],
            'bTargets': ['no-sort']
        }]
    });
    $('#arrival_table').dataTable({
        "language":{
            "url": "/js/datatableLanguage.json"
        },
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "dom": 'T<"clear">lfrtip',
        "sPaginationType": "full_numbers",
        "bLengthChange": false,
        'aoColumnDefs': [{
            'bSortable': false,
            'searchable': false,
            'aTargets': ['no-search'],
            'bTargets': ['no-sort']
        }],
        "order": [[ 10, "desc" ]]
    });
    $('#departure_cencel_table').dataTable({
        "language":{
            "url": "/js/datatableLanguage.json"
        },
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "dom": 'T<"clear">lfrtip',
        "sPaginationType": "full_numbers",
        "bLengthChange": false,
        'aoColumnDefs': [{
            'bSortable': false,
            'searchable': false,
            'aTargets': ['no-search'],
            'bTargets': ['no-sort']
        }],
        "order": [[ 3, "desc" ]]
    });
    $('#arrival_cencel_table').dataTable({
        "language":{
            "url": "/js/datatableLanguage.json"
        },
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "dom": 'T<"clear">lfrtip',
        "sPaginationType": "full_numbers",
        "bLengthChange": false,
        'aoColumnDefs': [{
            'bSortable': false,
            'searchable': false,
            'aTargets': ['no-search'],
            'bTargets': ['no-sort']
        }],
        "order": [[ 3, "desc" ]]
    });


    $("#arrival_table_filter").css("visibility", "hidden");

    $('#order_search_box1').keyup( function() {
        $("#departure_table_filter").css("visibility", "hidden");
        $('#departure_table').dataTable().api().search($(this).val()).draw();
    });

    $('#order_search_box2').keyup( function() {
        $('#arrival_table').dataTable().api().search($(this).val()).draw();
    });

    $('#order_search_box3').keyup( function() {
        $('#departure_cencel_table').dataTable().api().search($(this).val()).draw();
    });

    $('#order_search_box4').keyup( function() {
        $('#arrival_cencel_table').dataTable().api().search($(this).val()).draw();
    });




</script>