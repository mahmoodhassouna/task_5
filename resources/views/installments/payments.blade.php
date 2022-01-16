<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">تسديد الاقساط</h1>
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
                            <div  class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-head-fixed">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم المشروع</th>
                                        <th> اسم المستفيد</th>
                                        <th>تاريخ الاستحقاق</th>
                                        <th>مبلغ القسط</th>
                                        <th> تاريخ الدفع</th>
                                        <th> المبلغ المدفوع </th>
                                        <th>حالة القسط </th>
                                        <th>العمليات </th>
                                    </tr>
                                    </thead>
                                    <tbody id="insPyments">

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

        <div class="modal fade" id="installmentPaymentsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">دفع قيمة القسط</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="display_error"></ul>
                        <form id="installmentsPaymentsForm"  method="post">
                            @csrf
                            <input type="hidden" name="installment_id" id="installment_id">

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">مبلغ القسط </label>
                                <input class="form-control form-control-lg" readonly  value="" name="installmentAmount2" id="installmentAmount2" type="text" placeholder="0">

                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">التاريخ</label>
                                <input class="form-control form-control-lg" readonly  value="{{date('d-m-Y')}}" name="paymentDate" id="paymentDate" type="text" placeholder="0">

                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label"> قيمة الدفعة </label>
                                <input class="form-control form-control-lg"   value="" name="amountPaid" id="amountPaid" type="text" placeholder="0">

                            </div>

                            <div class="form-group form-group-lg">
                                <label>المحفظة</label>
                                <select name="wallet_id" class="form-control select2" style="width: 100%;">
                                    <option selected="selected " disabled>-- اختر المحفظة --</option>
                                     @isset($wallets)
                                         @foreach($wallets as $item)
                                    <option value="{{$item->id}}">{{$item->walletName}}</option>
                                        @endforeach
                                    @endisset

                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">دفع</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


    @stop



</x-app-layout>
