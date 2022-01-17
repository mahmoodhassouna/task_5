<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">الاقساط المستحقة</h1>
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <!-- /.card-header -->

                                <table class="table table-head-fixed">
                                    <thead>

                                    <tr>
                                        <form id="installmentsSearchForm" method="post">
                                            <th>
                                                <div class="col">
                                                    <label>اسم المستفيد</label>
                                                    <input name="beneficiaryName" class="form-control form-control-lg">
                                                </div>


                                            </th>
                                            <th>
                                                <div class="col">
                                                    <label>اسم المشروع</label>
                                                    <input name="projectName" class="form-control form-control-lg">
                                                </div>

                                            </th>

                                            <th></th>
                                            <th>
                                                <div class="col">
                                                    <label>تاريخ الاستحقاق من</label>
                                                    <input name="dateFrom" type="date" class="form-control form-control-lg">
                                                </div>

                                            </th>

                                            <th> </th>

                                            <th>
                                                <div class="col">
                                                    <label>تاريخ الاستحقاق الى</label>
                                                    <input name="dateTo" type="date" class="form-control form-control-lg">
                                                </div>
                                            </th>
                                            <th>
                                                <div class="col">
                                                    <button  class="btn btn-info">بحث</button>
                                                </div>
                                            </th>
                                        </form>
                                    </tr>

                                    </thead>
{{--                                    <tbody id="installmentsSerch">--}}
{{--                                    <tr>--}}

{{--                                    </tr>--}}

{{--                                    </tbody>--}}
                                </table>

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

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
                                    </tr>
                                    </thead>
                                    <tbody id="installmentsDue">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> لا يوجد اقساط مستحقة في الشهر الحالي</td>
                                        <td></td>
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

    @stop



</x-app-layout>
