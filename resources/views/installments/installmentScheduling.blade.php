<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">جدولة الاقساط الغير مسددة</h1>
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
                                        <th>اسم المستفيد</th>
                                        <th>تاريخ الاستحقاق</th>
                                        <th>مبلغ القسط</th>
                                        <th>حالة القسط </th>
                                        <th>العمليات </th>

                                    </tr>
                                    </thead>
                                    <tbody id="installmentScheduling">
                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> لا يوجد اقساط </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>

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


        <div class="modal fade" id="installmentSchedulingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">جدولة الاقساط</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="display_error"></ul>
                        <form id="installmentsSech"  method="post">
                            @csrf
                            <input type="hidden" name="installment_id" id="installment_id">
                            <input type="hidden" name="orderr_id" id="orderr_id">

                            <div class="form-group">
                                <label for="message-text" class="col-form-label">مبلغ القسط </label>
                                <input class="form-control form-control-lg"  value="" name="installmentAmount" id="installmentAmount" type="text" placeholder="0">

                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">تاريخ القسط</label>
                                <input class="form-control form-control-lg"  value="" name="newData" id="newData" type="date" placeholder="0">

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-info">حفظ</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


    @stop



</x-app-layout>
