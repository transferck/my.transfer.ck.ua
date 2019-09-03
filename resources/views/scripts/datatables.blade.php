{{-- FYI: Datatables do not support colspan or rowpan --}}

<script type="text/javascript" src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/moment.min.js')}}"></script>

<script src="{{asset('js/flatpickr.min.js')}}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>


<script type="text/javascript">
    var fromFilter = flatpickr("#all_new_table_from", {
        locale: "ru",
        enableTime: false,
        dateFormat: "Y-m-d",
        time_24hr: true,
    });

    var toFilter = flatpickr("#all_new_table_to", {
        locale: "ru",
        enableTime: false,
        dateFormat: "Y-m-d",
        time_24hr: true,
    });

    @if(isset($ordersJson))
    $(document).ready(function() {

        var allTable = {
            name: 'all_new_table',
            el: '#all_new_table',
            paginationEl: '#all_new_table_pagination',
            countEl: '#all_new_table_count',
            infoEl: '#all_new_table_info',
            orderEl: '.all_new_table_order',

            data: {
                {{--jsonData: `{!! $ordersJson !!}`,--}}
                allItems: [],
                ownIdsJson: `{!! $ownOrdersIds !!}`,
                ownIds: [],
                filtersData: {
                    to: null,
                    from: null,
                    id: null,
                    name: null,
                    phone: null,
                    status: null,
                    user_id: null,
                },
                orderBy: {
                    col: 'updated_at',
                    order: 'DESC',
                    availableColumns: [
                        'id', 'datetime', 'updated_at'
                    ]
                },
                dirtyFilters: false,
                dirtyForm: false,
                pages: [[], []],
                countPerPage: 10,
                page: 1,
                totalCount: {!! $ordersCount !!},
                csrfToken: '{{ csrf_token() }}',
                loaded: false,
                isRendering: false,
                isRequesting: false,
                needNewRequest: false,
                disablePagination: false,
                @role('admin')
                isAdmin: true,
                @endrole
                @role(['user', 'unverified', 'operator', 'agent'])
                isAdmin: false,
                @endrole
                roles: [
                    @role('admin')
                    'admin',
                    @endrole
                    @role('operator')
                    'operator',
                    @endrole
                    @role('agent')
                    'agent',
                    @endrole
                ],
                ordersTrans: {
                    statusOrder: {
                        sent: '{!! trans('ordersmanagement.orders-table.status_order_sent') !!}',
                        reservation: '{!! trans('ordersmanagement.orders-table.status_order_reservation') !!}',
                        cancel: '{!! trans('ordersmanagement.orders-table.status_order_cancel') !!}',
                        moved: '{!! trans('ordersmanagement.orders-table.status_order_moved') !!}',
                        update: '{!! trans('ordersmanagement.orders-table.status_order_update') !!}',
                        success: '{!! trans('ordersmanagement.orders-table.status_order_success') !!}',
                        needCancelConfirmation: '{!! trans('ordersmanagement.orders-table.status_order_need_cancel_confirmation') !!}',
                    },
                    ticketFreeReason: {
                        customerpaid: '{!! trans('ordersmanagement.orders-table.ticketfree_reason_customerpaid') !!}',
                        cardpersonal: '{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardpersonal') !!}',
                        cardgold: '{!! trans('ordersmanagement.orders-table.ticketfree_reason_cardgold') !!}',
                        discountfive: '{!! trans('ordersmanagement.orders-table.ticketfree_reason_discountfive') !!}',
                        discounthalf: '{!! trans('ordersmanagement.orders-table.ticketfree_reason_discounthalf') !!}',
                        balance: '{!! trans('ordersmanagement.orders-table.ticketfree_reason_balance') !!}',
                    },
                    buttons: {
                        delete: '{!! trans('ordersmanagement.buttons.delete') !!}',
                        reservation: '{!! trans('ordersmanagement.buttons.reservation') !!}',
                        cancel: '{!! trans('ordersmanagement.buttons.cancel') !!}',
                        show: '{!! trans('ordersmanagement.buttons.show') !!}',
                        edit: '{!! trans('ordersmanagement.buttons.edit') !!}'
                    },
                    statusPay1: '{!! trans('ordersmanagement.orders-table.status_pay_1') !!}',
                    statusPay2: '{!! trans('ordersmanagement.orders-table.status_pay_2') !!}',
                    ordersMenuAlt: '{!! trans('ordersmanagement.orders-menu-alt') !!}',
                },

            },

            elements: {
                fromFilter: null,
                toFilter: null,
                idFilter: null,
                nameFilter: null,
                phoneFilter: null,
                statusFilter: null,
                userIdFilter: null,
            },

            /** Initializers **/
            init: function () {
                this.helpers.isInArray = this.helpers.isInArray.bind(this);

                this.toggleLoading();

                this.loadAllData();

                this.initFilters();
                this.initHandlers();

                setInterval(this.loadAllData.bind(this), 10000);
            },

            initHandlers: function () {
                var pagination = $(this.paginationEl),
                    count = $(this.countEl),
                    self = this;

                pagination.on('click', '.paginate_button a', function () {
                    if (self.data.disablePagination) return;

                    var index = +$(this).data('idx');

                    if (!isNaN(index)) {
                        self.changePage(index);
                    }
                });

                count.on('change', 'select', function () {
                    var val = +this.value;

                    if (!isNaN(val)) {
                        self.data.countPerPage = val;

                        if (self.data.page > self.pagesCount())
                            self.data.page = 1;

                        self.rerender();
                    }
                });

                $( document ).click(function() {
                    $('.tooltip').remove();
                });

                this.handlers.dateFilters.call(this);
                this.handlers.submitFilters.call(this);
                this.handlers.ordering.call(this);
            },

            initFilters: function() {
                this.elements.fromFilter = $('input#' + this.name + '_from');
                this.elements.toFilter = $('input#' + this.name + '_to');
                this.elements.idFilter = $('input#' + this.name + '_id');
                this.elements.nameFilter = $('input#' + this.name + '_name');
                this.elements.phoneFilter = $('input#' + this.name + '_phone');
                this.elements.statusFilter = $('select#' + this.name + '_status');
                this.elements.userIdFilter = $('select#' + this.name + '_user_id');
            },

            /** Grouped **/
            helpers: {
                pagination: function () {
                    var firstIndex = (this.data.page - 1) * this.data.countPerPage + 1;
                    var lastIndex = (this.data.page) * this.data.countPerPage;

                    if (lastIndex > this.data.totalCount)
                        lastIndex = this.data.totalCount;

                    return {
                        firstIndex: firstIndex,
                        lastIndex: lastIndex
                    }
                },

                renderText: function (text) {
                    if (text == null || text == undefined)
                        return '';

                    return text;
                },
                isInArray(item, array) {
                    for (var idx in array)
                        if (item === array[idx]) return true;

                    return false;
                }
            },

            handlers: {
                submitFilters: function () {
                    $('#all_new_table_form').submit(function (event) {
                        event.preventDefault();

                        if (this.data.dirtyFilters) {
                            this.data.filtersData.from = this.elements.fromFilter.val();
                            this.data.filtersData.to = this.elements.toFilter.val();
                            this.data.filtersData.id = this.elements.idFilter.val();
                            this.data.filtersData.name = this.elements.nameFilter.val();
                            this.data.filtersData.phone = this.elements.phoneFilter.val();
                            this.data.filtersData.status = this.elements.statusFilter.val();
                            this.data.filtersData.user_id = this.elements.userIdFilter.val();

                            this.data.dirtyForm = true;
                            this.toggleLoading();
                            this.loadAllData();
                        }
                    }.bind(this))

                    $('#all_new_table_reset').click(function (event) {
                        event.preventDefault();

                        for (var key in this.data.filtersData) {
                            this.data.filtersData[key] = null;
                        }

                        for (var key in this.elements) {
                            this.elements[key].val('');
                        }

                        this.data.dirtyFilters = false;
                        this.data.dirtyForm = false;

                        this.toggleLoading();
                        this.loadAllData();
                    }.bind(this));
                },

                dateFilters: function () {
                    this.elements.fromFilter.change(function () {
                        this.data.dirtyFilters = true;
                    }.bind(this));

                    this.elements.toFilter.change(function () {
                        this.data.dirtyFilters = true;
                    }.bind(this));

                    this.elements.idFilter.change(function () {
                        this.data.dirtyFilters = true;
                    }.bind(this));

                    this.elements.nameFilter.change(function () {
                        this.data.dirtyFilters = true;
                    }.bind(this));

                    this.elements.phoneFilter.change(function () {
                        this.data.dirtyFilters = true;
                    }.bind(this));

                    this.elements.statusFilter.change(function () {
                        this.data.dirtyFilters = true;
                    }.bind(this));

                    this.elements.userIdFilter.change(function () {
                        this.data.dirtyFilters = true;
                    }.bind(this));
                },

                ordering: function () {
                    $('.all_new_table_order').click(function (event) {
                        var eventCol = event.target.getAttribute('data-col'),
                            isAvailable = false;

                        for (var id in this.data.orderBy.availableColumns) {
                            if (this.data.orderBy.availableColumns[id] === eventCol) {
                                isAvailable = true;
                                break;
                            }
                        }

                        if (isAvailable) {
                            if (this.data.orderBy.col === eventCol) {
                                var order = this.data.orderBy.order === 'ASC' ? 'DESC' : 'ASC';
                                this.data.orderBy.order = order;
                            } else {
                                this.data.orderBy.col = eventCol;
                                this.data.orderBy.order = 'DESC';
                            }

                            this.toggleLoading();
                            this.loadAllData();
                        }
                    }.bind(this));
                },
            },

            /** Computed **/
            pagesCount: function () {
                return Math.ceil(this.data.totalCount / this.data.countPerPage);
            },

            currentPage: function () {
                var items = this.data.allItems;

                items = items.slice((this.data.page - 1) * this.data.countPerPage, this.data.countPerPage * this.data.page);

                return items;
            },

            /** Methods **/
            toggleLoading: function (action = false) {
                // action = true    - Show
                // action = false   - Hide
                if (action) {
                    this.data.disablePagination = false;
                    $(this.el + ' tbody').css('opacity', 1);
                    $(this.el + '_form button').removeAttr('disabled');
                    $(this.el + '_form input').removeAttr('disabled');
                    $(this.el + '_form select').removeAttr('disabled');
                    $(this.countEl + ' select').removeAttr('disabled');
                } else {
                    this.data.disablePagination = true;
                    $(this.el + ' tbody').css('opacity', 0.6);
                    $(this.el + '_form button').attr('disabled', 'disabled');
                    $(this.el + '_form input').attr('disabled', 'disabled');
                    $(this.el + '_form select').attr('disabled', 'disabled');
                    $(this.countEl + ' select').attr('disabled', 'disabled');
                }
            },

            formatDatetime: function (datetime, format) {
                var date = moment(datetime, 'YYYY-MM-DD HH:mm:ss');

                return date.format(format)
            },

            getStatus: function (order) {
                var statusOrder = this.data.ordersTrans.statusOrder[order.status_order] || '-';
                var statusPay = null;

                if (order.status_order === 'cancel' && order.cancel_info)
                    statusOrder = '<span class="badge badge-danger" data-toggle="tooltip" title="Отменено (' + order.cancel_info +
                        ')"><i class="fa fa-times-circle" aria-hidden="true"></i></span>';

                if (order.need_cancel_confirmation)
                    statusOrder = this.data.ordersTrans.statusOrder.needCancelConfirmation;

                if (order.status_pay === 'not-paid')
                    statusPay = this.data.ordersTrans.statusPay1;
                else if (order.status_pay === 'paid')
                    statusPay = this.data.ordersTrans.ticketFreeReason[order.ticketfree_reason] ||
                        this.data.ordersTrans.statusPay2;
                else
                    statusPay = '-';

                window.ticket = this.data.ordersTrans.ticketFreeReason;

                return statusOrder + statusPay;
            },

            changePage: function (page) {
                this.data.page = page;

                this.rerender();
            },

            loadAllData: function () {
                var xhr = new XMLHttpRequest();

                // Если функция получила задание выполнить новый запрос, пока выполняется старый
                // функция устанавливает статус, чтобы выполнить новый после того, как
                // закончится старый
                if (this.data.isRequesting) {
                    this.data.needNewRequest = true;
                    return;
                }

                var paramsStr = '';

                if (this.data.dirtyForm) {
                    var valuesUrl = [];

                    for (var key in this.data.filtersData)
                        if (this.data.filtersData[key])
                            valuesUrl.push('filters[' + key + ']=' +  encodeURIComponent(this.data.filtersData[key]));

                    paramsStr += valuesUrl.join('&');
                }

                var url = '/orders-all/api?';

                url += 'order-by[col]=' + this.data.orderBy.col + '&order-by[order]=' + this.data.orderBy.order;
                if (paramsStr) url += '&' + paramsStr;

                xhr.open('GET', url, true);

                this.data.isRequesting = true;
                xhr.send();

                self = this;

                xhr.onreadystatechange = function () {
                    if (xhr.readyState !== 4) return;

                    if (xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText.replace(/\r?\n|\r/g, ''));

                        self.data.allItems = data.items;
                        self.data.totalCount = +data.totalCount;
                        self.data.ownIds = data.ownItemsIds;

                        self.data.isRequesting = false;

                        if (self.data.needNewRequest) {
                            self.data.needNewRequest = false;
                            self.loadAllData();
                        } else {
                            self.rerender();

                            self.toggleLoading(true);
                        }
                    }
                }
            },

            /** Render Methods **/
            rerender: function () {
                this.renderList();
                this.renderPagination();
                this.renderChangeCount();
                this.renderOrdering();
            },

            renderOrdering: function () {
                $(this.orderEl).removeClass('sorting');
                $(this.orderEl).removeClass('sorting_asc');
                $(this.orderEl).removeClass('sorting_desc');

                $(this.orderEl + ':not(' +
                    this.orderEl + '[data-col=' + this.data.orderBy.col + ']' +
                    ')').addClass('sorting');

                $(this.orderEl + '[data-col=' + this.data.orderBy.col + ']')
                    .addClass('sorting_' + this.data.orderBy.order.toLowerCase());
            },

            getPaginationButtons: function () {
                var count = this.pagesCount(),
                    elements = [];

                if (count < 10)
                    for (var i = 1; i <= count; i++)
                        elements.push('<li class="paginate_button page-item' + (i === this.data.page ? ' active' : '') + '">' +
                                        '<a href="#" aria-controls="' + this.name + '"' +
                                        'data-idx="' + i + '" tabindex="0"' +
                                        'class="page-link">' + i + '</a></li>');
                else {
                    elements.push('<li class="paginate_button page-item' + (1 === this.data.page ? ' active' : '') + '">' +
                        '<a href="#" aria-controls="' + this.name + '"' +
                        'data-idx="1" tabindex="0"' +
                        'class="page-link">1</a></li>');

                    if (this.data.page - 6 <= 0)
                        for (var i = 2; i <= this.data.page; i++)
                            elements.push('<li class="paginate_button page-item' + (i === this.data.page ? ' active' : '') + '">' +
                                '<a href="#" aria-controls="' + this.name + '"' +
                                'data-idx="' + i + '" tabindex="0"' +
                                'class="page-link">' + i + '</a></li>');
                    else {
                        elements.push('<li class="paginate_button page-item"><a href="#" aria-controls="all_table"' +
                            'data-idx="..." tabindex="0" class="page-link">...</a></li>');

                        for (var i = this.data.page - 4; i <= this.data.page; i++)
                            elements.push('<li class="paginate_button page-item' + (i === this.data.page ? ' active' : '') + '">' +
                                '<a href="#" aria-controls="' + this.name + '"' +
                                'data-idx="' + i + '" tabindex="0"' +
                                'class="page-link">' + i + '</a></li>');
                    }

                    if (this.data.page + 6 > count)
                        for (var i = this.data.page + 1; i < count; i++)
                            elements.push('<li class="paginate_button page-item">' +
                                '<a href="#" aria-controls="' + this.name + '"' +
                                'data-idx="' + i + '" tabindex="0"' +
                                'class="page-link">' + i + '</a></li>');
                    else {
                        for (var i = this.data.page + 1; i < this.data.page + 4; i++)
                            elements.push('<li class="paginate_button page-item">' +
                                '<a href="#" aria-controls="' + this.name + '"' +
                                'data-idx="' + i + '" tabindex="0"' +
                                'class="page-link">' + i + '</a></li>');

                        elements.push('<li class="paginate_button page-item"><a href="#" aria-controls="' + this.name + '"' +
                                        'data-idx="..." tabindex="0" class="page-link">...</a></li>');
                    }

                    if (this.data.page !== count)
                        elements.push('<li class="paginate_button page-item' + (count === this.data.page ? ' active' : '') + '">' +
                                        '<a href="#" aria-controls="' + this.name + '"' +
                                        'data-idx="' + count + '" tabindex="0"' +
                                        'class="page-link">' + count + '</a></li>')
                }

                return elements.join('');
            },

            getOptionsMenu: function(item) {
                var menu = '';

                menu += '<td>' +
                    '<div class="btn-group pull-right btn-group-xs">' +
                        '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                            '<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>' +
                            '<span class="sr-only">' +
                                this.data.ordersTrans.ordersMenuAlt +
                            '</span>' +
                        '</button>' +
                    '<div class="dropdown-menu dropdown-menu-right bg-white py-2">' +
                        '<a class="dropdown-item" href="{{ URL::to("orders/") }}/' + item.id + '" target="_blank">' +
                            this.data.ordersTrans.buttons.show +
                        '</a>';

                if (this.data.isAdmin)
                    menu += '<a class="dropdown-item" href="{{ URL::to('orders/') }}/' + item.id + '/edit" target="_blank">' +
                                this.data.ordersTrans.buttons.edit +
                            '</a>' +
                            '<form method="POST" action="{{ URL::to("orders/") }}/' + item.id + '" accept-charset="UTF-8" data-toggle="tooltip" title="" data-original-title="Delete">' +
                                '<input name="_token" type="hidden" value="' + this.data.csrfToken + '">' +
                                '<input name="_method" type="hidden" value="DELETE">' +
                                '<button type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete Order"' +
                                    'data-message="Are you sure you want to delete this order ?"' +
                                    'class="dropdown-item text-danger"' +
                                    'style="width: 100%;">' +
                                        this.data.ordersTrans.buttons.delete +
                                '</button>' +
                            '</form>';

                menu += '<div class="dropdown-divider"></div>';

                if ((this.helpers.isInArray('admin', this.data.roles) || this.helpers.isInArray('operator', this.data.roles)) &&
                    item.need_cancel_confirmation)
                    menu += '<form method="POST" action="{{ URL::to('orders/') }}/' + item.id + '/cancel/confirm" accept-charset="UTF-8"' +
                        'data-toggle="tooltip" title="" data-original-title="Подтвердить отмену">' +
                        '<input name="_token" type="hidden" value="' + this.data.csrfToken + '">' +
                        '<input name="_method" type="hidden" value="GET">' +
                        '<input name="cancel_info" type="hidden" value="' + item.cancel_info + '">' +
                        '<button type="button" data-toggle="modal" data-target="#confirmСancelConfirm" data-title="Подтвердить отмену"' +
                        'data-message="Вы уверены, что хотите изменить статус брони?" class="dropdown-item text-danger" style="width: 100%;">' +
                            'Подтвердить отмену' +
                        '</button>' +
                        '</form>';

                if (item.status_order !== 'reservation')
                    menu += '<form method="POST"' +
                            'action="{{ URL::to('orders/') }}/' + item.id + '/reservation"' +
                            'accept-charset="UTF-8" data-toggle="tooltip" title="" data-original-title="Подтвердить бронь">' +
                                '<input name="_token" type="hidden" value="' + this.data.csrfToken + '">' +
                                '<input name="_method" type="hidden" value="GET">' +
                                '<button type="button" data-toggle="modal"' +
                                'data-target="#confirmReservation"' +
                                'data-title="Одобрить бронь"' +
                                'data-message="Вы уверены, что хотите изменить статус брони?"' +
                                'class="dropdown-item text-success" style="width: 100%;">' +
                                    this.data.ordersTrans.buttons.reservation +
                                '</button>' +
                            '</form>';

                menu += '<form method="POST" action="{{ URL::to('orders/') }}/' + item.id + '/cancel" accept-charset="UTF-8"' +
                            'data-toggle="tooltip" title="" data-original-title="Отменить бронь">' +
                            '<input name="_token" type="hidden" value="' + this.data.csrfToken + '">' +
                            '<input name="_method" type="hidden" value="GET">' +
                                '<button type="button" data-toggle="modal" data-target="#confirmСancel" data-title="Отменить бронь"' +
                                'data-message="Вы уверены, что хотите изменить статус брони?" class="dropdown-item text-danger" style="width: 100%;">' +
                                    this.data.ordersTrans.buttons.cancel +
                                '</button>' +
                        '</form>' +
                        '</div>' +
                    '</div>' +
                '</td>';

                return menu;
            },

            renderList: function () {
                var tableRows = [];
                this.data.isRendering = true;

                for (i = 0; i < this.currentPage().length; i++) {
                    tableRows.push( this.renderItem(this.currentPage()[i]) );
                }

                this.data.isRendering = false;

                $(this.el + ' tbody#orders_table').empty();
                $(this.el + ' tbody#orders_table').append(tableRows.join(' '));

                $(this.el + ' [data-toggle="tooltip"]').tooltip();
            },

            renderItem: function (item) {
                var itemStr = "";

                itemStr += '<tr>';
                if (item.created_at === item.updated_at)
                    itemStr += '<td>' +
                                    '<span data-toggle="tooltip" title="' + this.formatDatetime(item.created_at, "DD.MM.Y, HH:mm") + '">' + item.id + '</span> ' +
                                '</td>';
                if (item.created_at !== item.updated_at)
                    itemStr += '<td>' +
                                    '<span data-toggle="tooltip" title="' + this.formatDatetime(item.created_at, "DD.MM.Y, HH:mm") + '">' + item.id + '</span> ' +
                                    '<span data-toggle="tooltip" title="' + this.formatDatetime(item.updated_at, "DD.MM.Y, HH:mm") + '"> ' +
                                    '<i class="fa fa-pencil" aria-hidden="true"></i></span>' +
                                '</td>';

                if (item.type === 'vl')
                    itemStr += '<td><span class="icons-table vl" data-toggle="tooltip" title="Вылет"></span></td>';
                if (item.type === 'pr')
                    itemStr += '<td><span class="icons-table pr" data-toggle="tooltip" title="Прилёт"></span></td>';
                if (!item.type)
                    itemStr += '<td>-</td>';

                itemStr += '<td>' + this.helpers.renderText.call(this, item.airport_ukraine) + ', ' + this.helpers.renderText.call(this, item.terminal) + '</td>';

                itemStr += '<td>' +
                                '<span data-toggle="tooltip" title="' + item.phone + '" data-original-title="' + item.phone + '"><i class="fa fa-mobile-phone" aria-hidden="true"></i></span> ' +
                                '<span data-toggle="tooltip" title="' + item.fio + '" data-original-title="' + item.fio + '">' + item.fio.substring(0, 12) + (item.fio.length > 12 ? '...' : '') + '</span>' +
                            '</td>';

                itemStr += '<td>';
                            if (item.option_nameplate == 1)
                                itemStr += '<span data-toggle="tooltip" title="Встреча с табличкой" data-original-title="Встреча с табличкой"><i class="fa fa-window-maximize" aria-hidden="true"></i></span>';
                            if (item.option_babyk == 1)
                                itemStr += '<span data-toggle="tooltip" title="Детское автокресло" data-original-title="Детское автокресло"><i class="fa fa-smile-o" aria-hidden="true"></i></span>';
                            if (item.option_babyl == 1)
                                itemStr += '<span data-toggle="tooltip" title="Детская автолюлька" data-original-title="Детская автолюлька"><i class="fa fa-smile-o" aria-hidden="true"></i></span>';
                            if (item.transfer === 'individual')
                                itemStr += '<span data-toggle="tooltip" title="Ценовая категория трансфера"><i class="fa fa-car" aria-hidden="true"></i></span>';
                itemStr += '</td>';

                if (item.ticket_child == 0 || item.ticket_child == null)
                    itemStr += '<td class="text-center">' + item.tickets + '</td>';
                else if (item.ticket_child > 0)
                    itemStr += '<td v-else-if="order" class="text-center">' + item.tickets + '+' + item.ticket_child + '</td>';
                else
                    itemStr += '<td v-else class="text-center">-</td>';

                if (item.type === 'vl')
                    itemStr += '<td>' + (item.registration == null ? '' : item.registration) + '</td>';
                else if (item.type === 'pr')
                    itemStr += '<td><span data-toggle="tooltip" title="' + (item.flight == null ? '' : item.flight) + '" data-original-title="' + (item.flight == null ? '' : item.flight) + '">' + (item.flight == null ? '' : item.flight.substring(0, 12) + (item.flight.length > 12 ? '...' : '')) + '</span></td>';
                else
                    itemStr += '<td>-</td>';

                itemStr += '<td>' + this.formatDatetime(item.datetime, 'DD/MM') + ', ' + this.formatDatetime(item.datetime, 'HH:mm') + '</td>';

                itemStr += '<td>';

                if (item.info)
                    itemStr += '<span data-toggle="tooltip" title="' + item.info + '">' +
                        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>' +
                    '</span>';

                itemStr += '</td>';

                itemStr += '<td>' + this.getStatus(item) + '</td>';

                itemStr += '<td><span data-toggle="tooltip" title="' + item.user.name + '">' + item.user.name.substring(0, 15) + (item.user.name.length > 15 ? '...' : '') + '</span></td>';

                itemStr += this.getOptionsMenu(item);

                itemStr += '</tr>';

                return itemStr;
            },

            renderPagination: function () {
                var strEl = [];
                var helper = this.helpers.pagination.call(this);

                if (this.data.page > this.pagesCount())
                    this.data.page = 1;

                var info = 'Записи с ' + helper.firstIndex + ' до ' + helper.lastIndex + ' из ' + this.data.totalCount + ' записей';

                $(this.infoEl).text(info);

                strEl.push('<ul class="pagination">');
                strEl.push('<li class="paginate_button page-item previous' + (1 === this.data.page ? ' disabled' : '') + '" id="all_table_previous">' +
                            '<a href="#" aria-controls="' + this.name + '" data-idx="' + (this.data.page - 1) + '" tabindex="0"' +
                            'class="page-link">«</a></li>');

                strEl.push(this.getPaginationButtons());

                strEl.push('<li class="paginate_button page-item next' + (this.pagesCount() === this.data.page ? ' disabled' : '') + '" id="all_table_next">' +
                                '<a href="#"' +
                                'aria-controls="' + this.name + '"' +
                                'data-idx="' + (this.data.page + 1) + '"' +
                                'tabindex="0"' +
                                'class="page-link">»</a>' +
                            '</li>');

                strEl.push('</ul>');

                $(this.paginationEl).empty();
                $(this.paginationEl).append(strEl.join(' '));
            },

            renderChangeCount: function () {
                var strEl = [];

                strEl.push('<select class="custom-select custom-select-sm form-control" style="width: auto;">');

                strEl.push('<option value="10"' + (this.data.countPerPage === 10 ? ' selected' : '') + '>10</option>');
                strEl.push('<option value="25"' + (this.data.countPerPage === 25 ? ' selected' : '') + '>25</option>');
                strEl.push('<option value="50"' + (this.data.countPerPage === 50 ? ' selected' : '') + '>50</option>');
                strEl.push('<option value="100"' + (this.data.countPerPage === 100 ? ' selected' : '') + '>100</option>');

                strEl.push('</select>');

                $(this.countEl).empty();
                $(this.countEl).append(strEl.join(' '));
            }
        };

        allTable.init();
        @endif

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
