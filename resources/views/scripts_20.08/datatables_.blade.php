{{-- FYI: Datatables do not support colspan or rowpan --}}


<script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        
        $('#agents_table').dataTable({
            "language":{
                "url": "/js/datatableLanguage.json"
            },
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "dom": 'T<"clear">lfrtip',
            "bLengthChange": false,
            'aoColumnDefs': [{
                'bSortable': false,
                'searchable': false,
                'aTargets': ['no-search'],
                'bTargets': ['no-sort']
            }],
            "order": [[ 3, "desc" ]]
        });

        $('#all_table').dataTable({
            "language":{
                "url": "/js/datatableLanguage.json"
            },
            //"processing": true,
            //"serverSide": true,
            //"ajax": "/allSearchRange",

            "paging": true,
            "lengthChange": true,
            "bFilter": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            "dom": 'T<"clear">lfrtip',
            "bLengthChange": false,
            'aoColumnDefs': [{
                'bSortable': false,
                'searchable': false,
                'aTargets': ['no-search'],
                'bTargets': ['no-sort']
            }],

        });

        $('#user_search_box').keyup( function() {
            $('#agents_table').dataTable().api().search($(this).val()).draw();
        });
        $('#order_search_box').keyup( function() {
            $('#all_table').dataTable().api().search($(this).val()).draw();
        });
        $('#all_table_filter').hide();
        $('#agents_table_filter').hide();

        $('#from').change( function(e) {
            e.preventDefault();
            console.log(1);
        });

    });



</script>
