<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">اضافة طلب</h1>
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
                <ul id="display_error"></ul>
                <div class="card card-success">

                    <div class="card-body">
                        <form id="addOrder" method="post" >
                            @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>اسم المشروع</label>
                                <input class="form-control form-control-lg" type="text" name="projectName" id="projectName">
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group">
                                    <label>التاريخ</label>
                                    <input class="form-control form-control-lg" type="text" readonly value="{{date('d-m-Y')}}" name="orderDate" id="orderDate">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                <label>اسم المستفيد</label>
                                <input class="form-control form-control-lg"   name="beneficiaryName"  id="beneficiaryName" type="text" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label>رقم الهوية</label>
                                <input class="form-control form-control-lg" name="idNumber" id="idNumber" type="text" placeholder="xxxxxxxxx">
                                </div>
                            </div>


                        </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group form-group-lg">
                                        <label>نوع المشروع</label>
                                        <select name="projectType" class="form-control select2" style="width: 100%;">
                                            <option selected="selected " disabled>-- اختر المشروع --</option>

                                                    <option value="صناعي">صناعي</option>
                                                    <option value="تجاري">تجاري</option>
                                                    <option value="زراعي">زراعي</option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>رقم الجوال</label>
                                    <input class="form-control form-control-lg" name="phone" id="phone" type="text" placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>مبلغ المشروع</label>
                                    <input class="form-control  form-control-lg" name="projectAmount" id="projectAmount" type="text" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>مدة تسديد مبلغ التمويل بالشهور</label>
                                        <input class="form-control form-control-lg" name="repaymentFinancingAmountMonths" id="repaymentFinancingAmountMonths" type="text" placeholder="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>مبلغ الربح المتوقع كل شهر</label>
                                        <input class="form-control form-control-lg" name="expectedProfit" id="expectedProfit" type="text" placeholder="0.00">
                                    </div>
                                </div>
                            </div>



                            <div class="card-footer">
                                <button class="btn btn-success float-right" type="submit">حفظ </button>
                            </div>
                        </form>
                    </div>
                     <!-- /.card-body -->
                </div>
            </div>
        </section>
    @stop



</x-app-layout>
