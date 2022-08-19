<div class="sidebar" data-active-color="green" data-background-color="white" data-image="{{URL::asset('assets/img/sidebar-1.jpg')}}">
    <!-- Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose" Tip 2: you can also add an image using data-image tag Tip 3: you can change the color of the sidebar with data-background-color="white | black" -->
    <div class="logo">
        <a href="{{route('/')}}" class="simple-text"> Inventory </a>
    </div>
    <div class="logo logo-mini">
        <a href="{{route('/')}}" class="simple-text"> Inv </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item {!! Request::is('/') ? 'active' : '' !!}">
                <a class="nav-link" href="{{route('/')}}">
                    <i class="material-icons">dashboard</i>
                    <p>Home</p>
                </a>
            </li>
            @if (Auth::user()->position=='Admin')
            <li class="nav-item {!! Request::is('admin*') ? 'active' : '' !!}">
                <a data-toggle="collapse" href="#admin">
                    <i class="material-icons">account_balance</i>
                    <p>Administration
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {!! Request::is('admin*') ? 'in' : '' !!}" id="admin">
                    <ul class="nav">
                        <li class="nav-item {!! Request::is('admin/status') ? 'active' : '' !!}">
                            <a href="{{route('/admin/status')}}">Status</a>
                        </li>
                        <li class="nav-item {!! Request::is('admin/user*') ? 'active' : '' !!}">
                            <a href="{{route('/admin/user')}}">Users</a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            @endif
            <li class="nav-item {!! Request::is('master*') ? 'active' : '' !!}">
                <a data-toggle="collapse" href="#master">
                    <i class="material-icons">group_work</i>
                    <p>Master
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {!! Request::is('master*') ? 'in' : '' !!}" id="master">
                    <ul class="nav">
                        <li class="nav-item {!! Request::is('master/transport') ? 'active' : '' !!}">
                            <a href="{{route('/master/transport')}}">Transportation</a>
                        </li>
                        <li class="nav-item {!! Request::is('master/customers') ? 'active' : '' !!}">
                            <a href="{{route('/master/customers')}}">Customers</a>
                        </li>
                        <li class="nav-item {!! Request::is('master/item') ? 'active' : '' !!}">
                            <a href="{{route('/master/item')}}">Item</a>
                        </li>
                        <li class="nav-item {!! Request::is('master/warehouse') ? 'active' : '' !!}">
                            <a href="{{route('/master/warehouse')}}">Warehouse</a>
                        </li>
                        <li class="nav-item {!! Request::is('master/units') ? 'active' : '' !!}">
                            <a href="{{route('/master/units')}}">Units</a>
                        </li>
                        <li class="nav-item {!! Request::is('master/documents') ? 'active' : '' !!}">
                            <a href="{{route('/master/documents')}}">Documents</a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li class="nav-item {!! Request::is('orders*') ? 'active' : '' !!}">
                <a data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">library_books</i>
                    <p>Inbound Orders
                        <b class="caret"></b>
                    </p>
                </a>
                <?php
                    if (Request::is('inbound_orders/show/*'|| Request::is('inbound_orders/edit/*'))) {
                        $active = 'active';
                    }else{
                        $active = '';
                    }
                ?>
                <div class="collapse {!! Request::is('inbound_orders*') ? 'in' : '' !!}" id="pagesExamples">
                    <ul class="nav">
                        <li class="nav-item {!! Request::is('inbound_orders/create') ? 'active' : '' !!}">
                            <a href="{{route('inbound_orders.create')}}">New Order</a>
                        </li>
                        @if(Request::is('inbound_orders/edit/*'))
                            <li class="nav-item {{ $active }}">
                                <a href="#">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Edit</a>
                            </li>
                        @endif
                        <li class="nav-item {!! Request::is('inbound_orders') ? 'active' : '' !!}">
                            <a href="{{route('inbound_orders.index')}}">History</a>
                        </li>
                        @if(Request::is('inbound_orders/show/*'))
                            <li class="nav-item {{ $active }}">
                                <a href="#">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Detail</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
            <?php
                if (Request::is('sales_inventory*') || Request::is('inventory/sale/show/*')) {
                    $active = 'active';
                    $in = 'in';
                }else{
                    $active = '';
                    $in = '';
                }
            ?>
            <li class="nav-item {!! Request::is('inventory*') ? 'active' : '' !!} {{ $active }}">
                <a data-toggle="collapse" href="#inventory">
                    <i class="material-icons">developer_board</i>
                    <p>Inventory
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {!! Request::is('inventory*') ? 'in' : '' !!} {{ $in }}" id="inventory">
                    <ul class="nav">
                        <li class="nav-item {!! Request::is('inventory') ? 'active' : '' !!}">
                            <a href="{{route('inventory.index')}}">Stock</a>
                        </li>
                        <li class="nav-item {!! Request::is('sales_inventory') ? 'active' : '' !!}">
                            <a href="{{route('sales_inventory.index')}}">History Sale</a>
                        </li>
                        @if(Request::is('inventory/sale/show/*'))
                            <li class="nav-item {{ $active }}">
                                <a href="#">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Detail</a>
                            </li>
                        @endif
                        <li class="nav-item {!! Request::is('inventory/sale') ? 'active' : '' !!}">
                            <a href="{{route('inventory/sale')}}">Order Form</a>
                        </li>
                        <li class="nav-item {!! Request::is('inventory/transfer') ? 'active' : '' !!}">
                            <a href="{{route('inventory/transfer')}}">Transfers</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>