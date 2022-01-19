<x-app-layout>
    @section('content')
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">استرداد الاقساط</h1>
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

           <form id="importForm" method="post" enctype="multipart/form-data">
               @csrf
               <div class="row">
                   <div class="col-12">
                       <div class="form-group">
                   <label>قم باختيار الملف</label>
                   <input class="form-control form-control-lg" type="file" name="file" id="file">
                       </div>
                       <div class="card-footer">
                           <div id="errorDiv">
                               <span>عمليات النجاح: </span>
                               <span id="countOfSuccess"></span>
                               <span>  عمليات الفشل: </span>
                               <span id="countOfFail"></span>
                               <ul id="messagesFail"></ul>
                           </div>

                           <button type="submit" class="btn btn-info float-right"> رفع الملف</button>
                       </div>
               </div>
               </div>
           </form>
            </div>
            </div>
            </div>
        </section>

    @stop



</x-app-layout>
