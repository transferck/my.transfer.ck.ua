<script>
    $(function() {
        var cardTitle = $('#card_title');
        var usersTable = $('#orders_table');
        var resultsContainer = $('#search_results');
        var ordersCount = $('#user_count');
        var clearSearchTrigger = $('.clear-search');
        var searchform = $('#search_orders');
        var searchformInput = $('#user_search_box');
        var userPagination = $('#user_pagination');
        var searchSubmit = $('#search_trigger');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        searchform.submit(function(e) {
            e.preventDefault();
            resultsContainer.html('');
            ordersTable.hide();
            clearSearchTrigger.show();
            let noResulsHtml = '<tr>' +
                                '<td>{!! trans("ordersmanagement.search.no-results") !!}</td>' +
                                '<td></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-sm hidden-xs"></td>' +
                                '<td class="hidden-sm hidden-xs hidden-md"></td>' +
                                '<td class="hidden-sm hidden-xs hidden-md"></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>';

            $.ajax({
                type:'POST',
                url: "{{ route('search-orders') }}",
                data: searchform.serialize(),
                success: function (result) {
                    let jsonData = JSON.parse(result);
                    if (jsonData.length != 0) {
                        $.each(jsonData, function(index, val) {
                            let rolesHtml = '';
                            let roleClass = '';
                            let showCellHtml = '<a class="btn btn-sm btn-success btn-block" href="orders/' + val.id + '" data-toggle="tooltip" title="{{ trans("ordersmanagement.tooltips.show") }}">{!! trans("ordersmanagement.buttons.show") !!}</a>';
                            let editCellHtml = '<a class="btn btn-sm btn-info btn-block" href="orders/' + val.id + '/edit" data-toggle="tooltip" title="{{ trans("ordersmanagement.tooltips.edit") }}">{!! trans("ordersmanagement.buttons.edit") !!}</a>';
                            let deleteCellHtml = '<form method="POST" action="/orders/'+ val.id +'" accept-charset="UTF-8" data-toggle="tooltip" title="Delete">' +
                                    '{!! Form::hidden("_method", "DELETE") !!}' +
                                    '{!! csrf_field() !!}' +
                                    '<button class="btn btn-danger btn-sm" type="button" style="width: 100%;" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="{!! trans("ordersmanagement.modals.delete_user_message", ["user" => "'+val.name+'"]) !!}">' +
                                        '{!! trans("ordersmanagement.buttons.delete") !!}' +
                                    '</button>' +
                                '</form>';

                            $.each(val.roles, function(roleIndex, role) {
                                if (role.name == "User") {
                                    roleClass = 'primary';
                                } else if (role.name == "Admin") {
                                    roleClass = 'warning';
                                } else if (role.name == "Unverified") {
                                    roleClass = 'danger';
                                } else {
                                    roleClass = 'default';
                                };
                                rolesHtml = '<span class="label label-' + roleClass + '">' + role.name + '</span> ';
                            });
                            resultsContainer.append('<tr>' +
                                '<td>' + val.id + '</td>' +
                                '<td>' + val.name + '</td>' +
                                '<td class="hidden-xs">' + val.email + '</td>' +
                                '<td class="hidden-xs">' + val.first_name + '</td>' +
                                '<td class="hidden-xs">' + val.last_name + '</td>' +
                                '<td class="hidden-sm hidden-xs"> ' + rolesHtml  +'</td>' +
                                '<td class="hidden-sm hidden-xs hidden-md">' + val.created_at + '</td>' +
                                '<td class="hidden-sm hidden-xs hidden-md">' + val.updated_at + '</td>' +
                                '<td>' + deleteCellHtml + '</td>' +
                                '<td>' + showCellHtml + '</td>' +
                                '<td>' + editCellHtml + '</td>' +
                            '</tr>');
                        });
                    } else {
                        resultsContainer.append(noResulsHtml);
                    };
                    ordersCount.html(jsonData.length + " {!! trans('ordersmanagement.search.found-footer') !!}");
                    userPagination.hide();
                    cardTitle.html("{!! trans('ordersmanagement.search.title') !!}");
                },
                error: function (response, status, error) {
                    if (response.status === 422) {
                        resultsContainer.append(noResulsHtml);
                        ordersCount.html(0 + " {!! trans('ordersmanagement.search.found-footer') !!}");
                        userPagination.hide();
                        cardTitle.html("{!! trans('ordersmanagement.search.title') !!}");
                    };
                },
            });
        });
        searchSubmit.click(function(event) {
            event.preventDefault();
            searchform.submit();
        });
        searchformInput.keyup(function(event) {
            if ($('#user_search_box').val() != '') {
                clearSearchTrigger.show();
            } else {
                clearSearchTrigger.hide();
                resultsContainer.html('');
                ordersTable.show();
                cardTitle.html("{!! trans('ordersmanagement.showing-all-orders') !!}");
                userPagination.show();
                ordersCount.html(" ");
            };
        });
        clearSearchTrigger.click(function(e) {
            e.preventDefault();
            clearSearchTrigger.hide();
            ordersTable.show();
            resultsContainer.html('');
            searchformInput.val('');
            cardTitle.html("{!! trans('ordersmanagement.showing-all-orders') !!}");
            userPagination.show();
            ordersCount.html(" ");
        });
    });
</script>
