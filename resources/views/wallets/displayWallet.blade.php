<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">بيانات المحفظة</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-success">

                    <div class="card-body">
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->

                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-2 invoice-col">
                                    <label>اسم المحفظة:</label>
                                    <p>{{$data->walletName}}</p>

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 invoice-col">
                                    <label>تاريخ الانشاء:</label>
                                    <p>{{$data->created_at}}</p>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2 invoice-col">
                                    <label>تاريخ الاغلاق:</label>
                                    <p>@isset($closeDate->closeDate){{$closeDate->closeDate}}@else -- @endisset</p>
                                </div>
                                <div class="col-sm-2 invoice-col">
                                    <label>المبلغ الاجمالي:</label>
                                    <p>{{$data->totalAmount}}</p>
                                </div>
                                <div class="col-sm-2 invoice-col">
                                    <label>المبلغ الاساسي:</label>
                                    <p>{{$data->baseAmount}}</p>
                                </div>
                                <div class="col-sm-2 invoice-col">
                                    <label>الصورة:</label>
                                    <p><img src="{{$data->attachWallet == null ? asset('images/s.png') : '/images/wallet/'.$data->attachWallet}}" alt="Girl in a jacket" width="120" height="60"></p>
                                </div>
                                <!-- /.col -->
                            </div><br><br>
                            <!-- /.row -->
                            <h3>حركات الاضافة</h3>
                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>قيمة الاضافة</th>
                                            <th>تاريخ الاضافة</th>
                                            <th>السبب</th>
                                            <th>الصورة</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        @isset($cash)
                                            @foreach($cash as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->additionAmount}}</td>
                                                    <td>{{$item->additionDate}}</td>
                                                    <td>{{$item->reason}}</td>
                                                    <td><img src="/images/addCash/{{$item->attachFile}}" alt="Girl in a jacket" width="100" height="60">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                            </tr>
                                        @endisset
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div><br>
                                 <h3>حركات السحب</h3>
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>قيمة السحب</th>
                                            <th>تاريخ السحب</th>
                                            <th>السبب</th>
                                            <th>الصورة</th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        @isset($withdraw)
                                            @foreach($withdraw as $item)
                                                <tr>
                                                    <td>{{$item->id}}</td>
                                                    <td>{{$item->withdrawAmount}}</td>
                                                    <td>{{$item->withdrawDate}}</td>
                                                    <td>{{$item->reason}}</td>
                                                    <td><img src="/images/withdraw/{{$item->attachFile}}" alt="Girl in a jacket" width="100" height="60"></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                            </tr>
                                        @endisset
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
    @stop



</x-app-layout>
