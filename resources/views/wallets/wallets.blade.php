<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">المحافظ</h1>
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

                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                         <a class="btn btn-info card-title" href="{{route('createWallet')}}">اضافة محفظة جديدة</a>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-head-fixed">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المحفظة</th>
                                        <th>الصورة</th>
                                        <th>المبلغ الاساسي</th>
                                        <th>المبلغ الاجمالي </th>
                                        <th>اعلى مبلغ يمكن سحبه </th>
                                        <th>البنك </th>
                                        <th>الحالة </th>
                                        <th>العمليات </th>
                                    </tr>
                                    </thead>
                                    <tbody id="wallets">
                                        <tr>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </section>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اغلاق محفظة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('closeWallet')}}" method="post">
                            @csrf
                            <input type="hidden" name="wallet_id" id="wallet_id">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">التاريخ</label>
                                <input type="text" name="closeDate" value="{{date('d-m-Y')}}" readonly class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">سبب الاغلاق</label>
                                <textarea maxlength="149" required name="reason" class="form-control" id="message-text"></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">اغلاق المحفظة</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @stop



</x-app-layout>
