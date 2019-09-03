@extends('layouts.app')

@section('template_title')
	Партнерская программа
@endsection

@section('head')
@endsection

@section('content')

<div class="container-fluid">
   <div class="row mt-3">
      <div class="col-sm-8">
         <div class="card">
            <div class="card-header">
               <h5 class="mb-0"> Все брони</h5>
            </div>
            <div class="card-body">
               <div class="table-responsive orders-table">
                  <table class="table table-striped table-sm data-table">
                     <caption id="order_count">
                        0 броней всего
                     </caption>
                     <thead class="thead">
                        <tr>
                           <th>ID</th>
                           <th>Имя</th>
                           <th><i aria-hidden="true" class="fa fa-users"></i></th>
                           <th><i aria-hidden="true" class="fa fa-plane"></i></th>
                           <th>Вылет</th>
                           <th>Регист.</th>
                           <th class="no-search no-sort"></th>
                           <th class="no-search no-sort"></th>
                           <th class="no-search no-sort"></th>
                        </tr>
                     </thead>
                     <tbody id="orders_table"></tbody>
                     <tbody id="search_results"></tbody>
                     <tbody id="search_results"></tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-4">
         <div class="card">
            <div class="card-header">
               <h5 class="mb-0"> Рейтинг агенств</h5>
            </div>
            <div class="card-body">
               <div class="table-responsive orders-table">
                  <table class="table table-striped table-sm data-table">
                     <caption id="order_count">
                        0 броней всего
                     </caption>
                     <thead class="thead">
                        <tr>
                           <th>ID</th>
                           <th>Имя</th>
						   <th>Броней</th>
                           <th><i aria-hidden="true" class="fa fa-users"></i></th>
                           <th><i aria-hidden="true" class="fa fa-star"></i></th>
                        </tr>
                     </thead>
                     <tbody id="orders_table"></tbody>
                     <tbody id="search_results"></tbody>
                     <tbody id="search_results"></tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection