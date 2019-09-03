<div class="row">
    <div class="col-sm-8 col-md-6 col-lg-5 col-xl-12">
        {!! Form::open(['route' => 'search-orders', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'search_orders']) !!}
            {!! csrf_field() !!}
            <div class="input-group">
                {!! Form::text('order_search_box', NULL, ['id' => 'order_search_box', 'class' => 'form-control', 'placeholder' => trans('ordersmanagement.search.search-orders-ph'), 'aria-label' => trans('ordersmanagement.search.search-orders-ph'), 'required' => false]) !!}
                <div class="input-group-append">
                    <a href="#" class="input-group-addon btn btn-warning clear-search" data-toggle="tooltip" title="{{ trans('ordersmanagement.tooltips.clear-search') }}" style="display:none;">
                        <i class="fa fa-fw fa-times" aria-hidden="true"></i>
                        <span class="sr-only">
                            {!! trans('ordersmanagement.tooltips.clear-search') !!}
                        </span>
                    </a>
                    <a href="#" class="input-group-addon btn btn-secondary" id="search_trigger" data-toggle="tooltip" data-placement="bottom" title="{{ trans('ordersmanagement.tooltips.submit-search') }}" >
                        <i class="fa fa-search fa-fw" aria-hidden="true"></i>
                        <span class="sr-only">
                            {!!  trans('ordersmanagement.tooltips.submit-search') !!}
                        </span>
                    </a>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
