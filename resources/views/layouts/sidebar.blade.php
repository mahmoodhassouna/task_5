<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{route('main')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        المحافظ
                        <span class="right badge badge-danger"></span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('orders')}}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        الطلبات
                        <span class="right badge badge-danger"></span>
                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                        الاقساط
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('installments')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>الاقساط المستحقة</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('installmentSchedulingView')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>جدولة الأقساط</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('insPyments')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>تسديد الاقساط</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('importExcel')}}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>استرداد الاقساط</p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
