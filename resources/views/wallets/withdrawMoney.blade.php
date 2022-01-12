<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"> سحب مبلغ </h1>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card card-success">
                    <ul id="display_error"></ul>
                    <div class="card-body">



                        <form  method="post" @isset($action) action="{{route('storeWithdrawWithClose')}}" @else id="withdrawFormData" @endisset enctype="multipart/form-data" >
                         @csrf
                            <input type="hidden" value="{{$wallet_id}}" name="wallet_id">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>المبلغ الاجمالي</label>
                                    <input class="form-control form-control-lg" readonly @isset($totalAmount) value="{{$totalAmount}}" @endisset @isset($totalAmount1->totalAmount) value="{{$totalAmount1->totalAmount}}" @endisset  id="totalAmountField" type="text" placeholder="0">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>   تاريخ السحب</label>
                                    <input class="form-control form-control-lg" name="withdrawDate" readonly type="text" value="{{date('d-m-Y')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>مبلغ السحب</label>
                                    <input class="form-control form-control-lg"  type="text"@isset($totalAmount) value="{{$totalAmount}}" @endisset name="withdrawAmount" id="withdrawAmount" placeholder="0">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>السبب</label>
                                    <textarea class="form-control" maxlength="149" rows="3" name="reason" id="reason" placeholder="السبب..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="customFile">المرفقات</label>
                                    <div class="custom-file">
                                        <input type="file" name="attachFile" class="custom-file-input" id="attachFile">
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
            </div>
        </section>
    @stop
</x-app-layout>
