@extends('welcome')

@section('title')
    Home
@endsection

@section('extra-css')
{{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/csshake/1.5.3/csshake.css') }}
    
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h3 class="title text-center">Reminders and alerts</h3>
        <br />
        <div class="nav-center">
            <ul class="nav nav-pills nav-pills-success nav-pills-icons" role="tablist">
                <li>
                    <a href="#description-1" role="tab" data-toggle="tab">
                        <i class="material-icons">flight</i> Airport
                    </a>
                </li>
                <li class="active">
                    <a href="#schedule-1" role="tab" data-toggle="tab">
                        <i class="material-icons">card_travel</i> Sale
                    </a>
                </li>
                <li>
                    <a href="#tasks-1" role="tab" data-toggle="tab">
                        <i class="material-icons">backspace</i> Expiration date
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane" id="description-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Products in Airport</h4>
                        <p class="category">
                            More information here
                        </p>
                    </div>
                    <div class="card-content">
                        <p>There are {{$airport_count}} Purchase Orders at the airport, remember to pass it to the warehouse</p>
                        <p>The documentation of {{$doc_air_count}} purchase orders is missing</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane active" id="schedule-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Sales of the product</h4>
                        <p class="category">
                            More information here
                        </p>
                    </div>
                    <div class="card-content">
                       <p> Proof of product pick up documentation pending in {{$doc_sale_count}} sales order</p>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tasks-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Expiration date of the product</h4>
                        <p class="category">
                            More information here
                        </p>
                    </div>
                    <div class="card-content">
                        @if( $dia_array !=  0)
                        @foreach ($dia_array as $key => $value)
                            @foreach ($inbound_order as $inb_or)
                                @if($key == $inb_or->diord_expiration_date)
                                <p>The product <b>{{$inb_or->item_name}}</b> , lot number <b>{{$inb_or->diord_lot}}</b>  expires on the <b><?PHP echo date('m/d/Y',strtotime($inb_or->diord_expiration_date));?></b>, <b>{{$value}}</b> days</p>
                                @endif
                            @endforeach
                        @endforeach
                        @endif
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('extra-script')
    <script type="text/javascript">
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            demo.initDashboardPageCharts();
            demo.initVectorMap();
        });
    </script>
@endsection