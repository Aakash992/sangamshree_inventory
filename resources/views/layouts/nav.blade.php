<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('assets/images/logo.png')}}" class="logo-icon" alt="logo icon">
        </div>

        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{route('admin.dashboard')}}" class="">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
           
        </li>
        <li class="menu-label">Inventory Elements</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Supplier</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.supplier.create') }}"><i class="bx bx-right-arrow-alt"></i>Create</a>
                </li>
                <li> <a href="{{ route('admin.supplier') }}"><i class="bx bx-right-arrow-alt"></i>View</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-car'></i>
                </div>
                <div class="menu-title">Product</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.product.create') }}"><i class="bx bx-right-arrow-alt"></i>Create</a>
                </li>
                <li> <a href="{{route('admin.product')}}"><i class="bx bx-right-arrow-alt"></i>View</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bxs-group'></i>
                </div>
                <div class="menu-title">Customer</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.customer.create') }}"><i class="bx bx-right-arrow-alt"></i>Create</a>
                </li>
                <li> <a href="{{route('admin.customer')}}"><i class="bx bx-right-arrow-alt"></i>View</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bxs-bar-chart-alt-2'></i>
                </div>
                <div class="menu-title">Sales</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.sales.index') }}"><i class="bx bx-right-arrow-alt"></i>View</a>
                </li>
            </ul>
        </li>
        
        
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->