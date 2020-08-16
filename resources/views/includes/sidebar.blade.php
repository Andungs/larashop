<aside class="main-sidebar sidebar-light-teal elevation-4 ">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('assets')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Shoping Dev</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('assets')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('dashbord')}}" class="nav-link {{Request::segment(1)=='dashbord'?'active':''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashbord
                        </p>
                    </a>
                </li>
                <li class="nav-header">Barang</li>
                <li class="nav-item mb-1">
                    <a href="{{route('category.index')}}"
                        class="nav-link {{Request::segment(1)=='category'?'active':'' }} ">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Kategori Barang
                        </p>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{route('product.index')}}"
                        class="nav-link {{Request::segment(1)=='product'?'active':'' }}">
                        <i class="nav-icon fas fa-box-open"></i>
                        <p>
                            Daftar Barang
                        </p>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{route('gallery.index')}}"
                        class="nav-link {{Request::segment(1)=='gallery'?'active':'' }}">
                        <i class="nav-icon fas fa-photo-video"></i>
                        <p>
                            Foto Barang
                        </p>
                    </a>
                </li>
                <li class="nav-header">Transaksi</li>
                <li class="nav-item mb-1">
                    <a href="{{route('transaction.index')}}"
                        class="nav-link {{Request::segment(1)=='transaction'?'active':'' }}">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            Daftar Transaksi
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
