<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">اضافة محفظة</h1>
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
                        <form id="addWallet" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>اسم المحفظة</label>
                                <input class="form-control form-control-lg" type="text" name="walletName" id="walletName">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label> المبلغ الأساسي</label>
                                <input class="form-control form-control-lg" oninput="myFunction()"  name="baseAmount" id="baseAmount" type="number" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                <label>المبلغ الإجمالي</label>
                                <input class="form-control form-control-lg"  readonly name="totalAmount"  id="totalAmount" type="number" placeholder="0">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label>أعلى مبلغ يمكن سحبه من المحفظة</label>
                                <input class="form-control form-control-lg" name="highestAmountCanWithdrawn" id="highestAmountCanWithdrawn" type="number" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-group-lg">
                                    <label>البنك الخاص بالمحفظة</label>
                                    <select name="banks_id" class="form-control select2" style="width: 100%;">
                                        <option selected="selected " disabled>-- اختر البنك --</option>
                                    @isset($banks)
                                        @foreach($banks as $item)
                                            <option value="{{$item->id}}">{{$item->bankName}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div> <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="customFile">المرفقات</label>
                                    <div class="custom-file">

                                        <input type="file" class="custom-file-input" name="attachWallet" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
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
