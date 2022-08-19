@extends('welcome')

@section('title')
    History Sale
@endsection

@section('extra-css')
    <style type="text/css">
        tfoot input {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
    </style>
    <link href="checkboxselrow/css/dataTables.checkboxes.css" rel="stylesheet"/>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">assignment</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Sales</h4>
                <div class="toolbar">
                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                </div>
                <div class="material-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>              
                                <th>Invoice number</th>
                                <th>Customer</th>
                                <th>Transport</th>
                                <th>Item</th>
                                <th>Batch</th>
                                <th class="disabled-sorting text-right">Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Invoice number</th>
                                <th>Name Co</th>
                                <th>Transport</th>
                                <th>Item</th>
                                <th>Batch</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($cab_sale_inv as $cab_sale)
                                <tr>
                                    <td><?PHP echo date('m/d/Y',strtotime($cab_sale->csaleinv_date));?></td>
                                    <td>{{$cab_sale->csaleinv_invoice}}</td>
                                    <td>{{$cab_sale->cust->cust_company}}</td>
                                    <td>
                                        @if(isset($cab_sale->csaleinv_tran_cust))
                                            {{$cab_sale->cust->cust_company}}
                                        @elseif($cab_sale->csaleinv_transport == 0)
                                            
                                        @else
                                        {{$cab_sale->trans->trans_company}}
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($det_sale_inv as $det_sale)
                                            @if($det_sale->id_csale_inventory == $cab_sale->id_csale_inventory)
                                                {{$det_sale->item->item_name}}<br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($det_sale_inv as $det_sale)
                                            @if($det_sale->id_csale_inventory == $cab_sale->id_csale_inventory)
                                                {{$det_sale->dsaleinv_lot}}<br>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class=" text-right">
                                        <a href="{{ url('inventory/sale/show/'. $cab_sale->id_csale_inventory) }} " class="btn btn-simple btn-info btn-icon"><i class="material-icons">find_in_page</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end content-->
        </div>
        <!--  end card  -->
    </div>
    <!-- end col-md-12 -->
</div>
<!-- /*<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-icon" data-background-color="green">
                <i class="material-icons">assignment_returned</i>
            </div>
            <div class="card-content">
                <h4 class="card-title">Track batch export</h4>
                <div class="toolbar">
                   
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::select('id_status', $lote_index, null, ['class' => 'selectpicker form-group batch', 'data-style' => 'select-with-transition', 'title' => 'Batch', 'data-size' => '7', 'data-live-search' => 'true','required' => 'true']) !!}
                            </div>
                            <input id="batchSelecionado" type="hidden" name="batch_select" >
                            <br>
                            <button class="btn btn-success btn-sm" onclick="Batch('')">
                                <span class="btn-label">
                                    <i class="material-icons">check</i>
                                </span>
                                Search
                                <div class="ripple-container"></div>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="material-datatables">
                    <form class="myform" action="{{ action('SaleInventoryController@pdf_batch') }}" method="get">
                        
                    
                        <table id="mytable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>    
                                    <th></th>  
                                    <th>Batch</th>  
                                    <th>Customer</th>  
                                    <th>Invoice number</th>
                                    <th>Date</th>
                                    <th>View</th> 
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>    
                                    <th></th>  
                                    <th>Batch</th>  
                                    <th>Customer</th>  
                                    <th>Invoice number</th>
                                    <th>Date</th>
                                    <th>View</th> 
                                </tr>
                            </tfoot>
                        </table>
                        <p><b>Selected rows data</b></p>
                        <pre id="view-rows"></pre>
                        <input type="" name="" class="prueba" value="">
                        
                        <p><button class="btn btn-danger " onclick="expor('')">View Selected</button><br/></p>
                    </form>
                </div>
            </div>
            
        </div>
        
    </div>
    
</div>*/ -->
@endsection

@section('extra-script')
<script src="checkboxselrow/js/dataTables.checkboxes.min.js"></script>
<script>
    $(document).ready(function(){
        
    })
</script>
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });

        $('#datatables tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" />' );
        });

        var table = $('#datatables').DataTable();

        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                    .search( this.value )
                    .draw();
                }
            } );
        } );

        $('.card .material-datatables label').addClass('form-group');
    });
</script>
    <script type="text/javascript">
        /*$(document).on('change', '.batch', function(event) {
            $('#batchSelecionado').val($(".batch option:selected").text());

        });

        function Batch() {
            var select_batch = $("#batchSelecionado").val();
            $('input[name="id\[\]"]').remove();
            $("#view-rows").text('')
            

            $.ajax({
                url: '{{ action('SaleInventoryController@batch') }}',
                method: 'get',
                data: {
                    select_batch: select_batch,
                },
                success: function(select_batch) {
                    
                    
                    var mytable = $("#mytable").DataTable({
                        "destroy": true,
                        "data": select_batch,
                        columnDefs: [
                            {
                                targets: 0,
                                checkboxes: {
                                    seletRow: true
                                }
                            },
                            { 
                                targets: 5,
                                searchable: false,
                                orderable: false,
                                render: function(data, type, full, meta){
                                    
                                   if(type === 'display'){
                                    var id = data;
                                    var url = '{{ url("inventory/sale/show/") }}/'+id;
                                      //data = '<input type="radio" name="id_delive" value="' + data + '" onclick="delive()">'; 
                                      data = '<a href="'+url+'" class="btn btn-simple btn-info btn-icon"><i class="material-icons">find_in_page</i></a>'
                                      console.log(data);    
                                   }
                                    
                                   return data;
                                }
                            }
                        ],
                        "columns":[
                            {"data":"id_dsale_inventory"},
                            {"data":"dsaleinv_lot"},
                            {"data":"cust_company"},
                            {"data":"csaleinv_invoice"},                                        
                            {"data":"csaleinv_date",
                                render: function(data){
                                    
                                    return moment(data).format("DD/MM/YYYY");
                                }
                            },
                            {"data":"id_dsale_inventory"}                                        
                            
                        ],
                        select:{
                            style: 'multi'
                        },
                        order: [[1, 'asc']]
                        
                    });
                    $(".myform").on('click', function(e){
                        var form = this
                        var rowsel = mytable.column(0).checkboxes.selected();

                        $.each(rowsel, function(index, rowId){
                             
                            $(form).append(
                                $('<input>').attr('type','hidden').attr('name','id[]').attr('class','id').val(rowId)
                            )

                            /*$.ajax({
                                url: "{{ action('SaleInventoryController@pdf_batch') }}",
                                method: 'get',
                                data: {
                                    rowId: rowId,
                                },
                                success: function(rowId) {
                                    
                                    
                                    
                                }
                            });//AJAX COMENTADO
                            
                        })
                        
                        $("#view-rows").text(rowsel.join(","))
                        //var porTagName=document.getElementsByTagName("input")[0].value;
                        var porId = document.getElementById("view-rows").innerHTML;
                        
                        e.preventDefault()
                        //$('input[name="id\[\]"]', form).remove()

                        
                       //alert(porId)


                        

                    })
                    
                }
            });
        }

        function expor(){
            //alert('expor');
        }*/
    </script>
@endsection