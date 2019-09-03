@extends('layouts.app')

@section('template_title')
    Партнерская программа
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/flatpickr.min.css" rel="stylesheet">


@section('content')

    <div class="container">
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"> Рейтинг агенств</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive orders-table">

							<form class="d-inline-flex row" id="agents_table_form">
                               <div class="col-md-3">
                                   <div class="input-group">
                                       <input id="agents_table_from" placeholder="Введите дату" name="from"
                                              value="{{Request::get('from')}}"
                                              type="text" class="form-control form-control-sm flatpickr-input">
                                       <div class="input-group-append">
                                           <label for="datetime" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-3">
                                   <div class="input-group">
                                       <input id="agents_table_to" placeholder="Введите дату" name="to"
                                              value="{{Request::get('to')}}"
                                              type="text" class="form-control form-control-sm flatpickr-input">
                                       <div class="input-group-append">
                                           <label for="datetime" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-calendar"></i></label>
                                       </div>
                                   </div>
                               </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input id="agents_table_name" placeholder="Введите имя" name="name"
                                               value="{{Request::get('name')}}"
                                               type="text" class="form-control form-control-sm">
                                        <div class="input-group-append">
                                            <label for="from" class="input-group-text"><i aria-hidden="true" class="fa fa-fw fa-user"></i></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <button class="btn btn-sm btn-success" type="submit">
                                        <i aria-hidden="true" class="fa fa-fw fa-search"></i> Найти
                                    </button>
                                    <button class="btn btn-info" id="agents_table_reset">
                                        <i aria-hidden="true" class="fa fa-fw fa-undo"></i>
                                    </button>
                                </div>
							</form>
                        </div>

                            <table class="table table-striped table-sm data-table" id="agents_table" style="margin-top: 10px;">
                                <thead class="thead">
                                <tr>
                                    <th class="agents_table_order" data-col="id">ID</th>
                                    <th class="agents_table_order" data-col="name">Агенство</th>
                                    <th class="agents_table_order" data-col="ordersCount">Броней создано</th>
                                    <th class="agents_table_order" data-col="successCount">Броней выполнено</th>
                                    <th class="agents_table_order" data-col="tickets">Пассажиров доставлено</th>
                                    <th class="agents_table_order" data-col="reward">Вознаграждение</th>
                                </tr>
								</thead>
								<tbody id="agents_table">
									@foreach($users->slice(0, 10) as $agent)
{{--                                        @if($agent->orders->count() == 0) @continue @endif--}}
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $agent->name }}</td>
                                            <td>{{ $agent->ordersCount }}</td>
                                            <td>{{ $agent->successCount }}</td>
                                            <td>{{ $agent->tickets }}</td>
                                            <td>{{ $agent->reward }} грн.</td>
                                        </tr>
									@endforeach
                                </tbody>
                            </table>

                            <div class="dataTables_info" id="agents_table_info" role="status" aria-live="polite">Записи с
                                1 до 10 из {{ $users->count() }} записей</div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="dataTables_paginate" id="agents_table_pagination">

                                </div>

                                <div class="dataTables_paginate" id="agents_table_count">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


@section('footer_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('js/flatpickr.min.js')}}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            var fromFilter = flatpickr("#agents_table_from", {
                locale: "ru",
                enableTime: false,
                dateFormat: "Y-m-d",
            });

            var toFilter = flatpickr("#agents_table_to", {
                locale: "ru",
                enableTime: false,
                dateFormat: "Y-m-d",
            });

            var allTable = {
                name: 'agents_table',
                el: '#agents_table',
                el: '#agents_table',
                paginationEl: '#agents_table_pagination',
                countEl: '#agents_table_count',
                infoEl: '#agents_table_info',
                orderEl: '.agents_table_order',

                data: {
                    {{--jsonData: `{!! $agentsJson !!}`,--}}
                    allItems: [],
                    ownIds: [],
                    filtersData: {
                        to: null,
                        from: null,
                        name: null,
                    },
                    orderBy: {
                        col: 'reward',
                        order: 'DESC',
                        availableColumns: [
                            'id', 'name', 'ordersCount', 'successCount', 'tickets', 'reward'
                        ]
                    },
                    dirtyFilters: false,
                    dirtyForm: false,
                    pages: [[], []],
                    countPerPage: 10,
                    page: 1,
                    totalCount: {!! $agentsCount !!},
                    csrfToken: '{{ csrf_token() }}',
                    loaded: false,
                    isRendering: false,
                    isRequesting: false,
                    needNewRequest: false,
                    disablePagination: false,
                },

                elements: {
                    fromFilter: null,
                    toFilter: null,
                    nameFilter: null,
                },

                /** Initializers **/
            init: function () {
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

                    this.handlers.dateFilters.call(this);
                    this.handlers.submitFilters.call(this);
                    this.handlers.ordering.call(this);
                },

                initFilters: function() {
                    this.elements.fromFilter = $('input#' + this.name + '_from');
                    this.elements.toFilter = $('input#' + this.name + '_to');
                    this.elements.nameFilter = $('input#' + this.name + '_name');
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
                        for (var i in array)
                            if (item === i) return true;

                        return false;
                    }
                },

                handlers: {
                    submitFilters: function () {
                        $(this.el + '_form').submit(function (event) {
                            event.preventDefault();

                            if (this.data.dirtyFilters) {
                                this.data.filtersData.from = this.elements.fromFilter.val();
                                this.data.filtersData.to = this.elements.toFilter.val();
                                this.data.filtersData.name = this.elements.nameFilter.val();

                                this.data.dirtyForm = true;
                                this.toggleLoading();
                                this.loadAllData();
                            }
                        }.bind(this));

                        $(this.el + '_reset').click(function (event) {
                            event.preventDefault();

                            for (var key in this.data.filtersData) {
                                this.data.filtersData[key] = null;
                            }

                            for (key in this.elements) {
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

                        this.elements.nameFilter.change(function () {
                            this.data.dirtyFilters = true;
                        }.bind(this));
                    },

                    ordering: function () {
                        $('.agents_table_order').click(function (event) {
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

                    var url = '/agents/api?';

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
                    $(this.orderEl).removeClass('order-asc');
                    $(this.orderEl).removeClass('order-desc');

                    $(this.orderEl + '[data-col=' + this.data.orderBy.col + ']')
                        .addClass('order-' + this.data.orderBy.order.toLowerCase());
                },

                getPaginationButtons: function () {
                    var count = this.pagesCount(),
                        elements = [];

                    if (count < 10)
                        for (i = 1; i <= count; i++)
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

                renderList: function () {
                    var tableRows = [],
                        totalItem = {
                            name: 'Total',
                            ordersCount: 0,
                            successCount: 0,
                            tickets: 0,
                            reward: 0
                        };

                    this.data.isRendering = true;

                    var startDifference = (this.data.page - 1) * this.data.countPerPage;

                    for (i = 0; i < this.currentPage().length; i++) {
                        var item = this.currentPage()[i];

                        tableRows.push( this.renderItem(item, startDifference + i + 1) );
                        totalItem.ordersCount += item.ordersCount;
                        totalItem.successCount += item.successCount;
                        totalItem.tickets += item.tickets;
                        totalItem.reward += item.reward;
                    }

                    tableRows.push( this.renderItem(totalItem, '') );

                    this.data.isRendering = false;

                    $(this.el + ' tbody#agents_table').empty();
                    $(this.el + ' tbody#agents_table').append(tableRows.join(' '));
                },

                renderItem: function (item, idx) {
                    var itemStr = "";
                    itemStr += '<tr>';

                    itemStr += '<td>' + idx + '</td>';
                    itemStr += '<td>' + item.name + '</td>';
                    itemStr += '<td>' + item.ordersCount + '</td>';
                    itemStr += '<td>' + item.successCount + '</td>';
                    itemStr += '<td>' + item.tickets + '</td>';
                    itemStr += '<td>' + item.reward + '</td>';

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
        });
    </script>

@endsection