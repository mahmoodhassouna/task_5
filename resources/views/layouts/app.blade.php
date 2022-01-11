<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">
    <style>
        label.error {
            color: red!important;
        }
        .error {
            color: #F00;

        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav mr-auto-navbav">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <span class="badge badge-danger navbar-badge">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{asset('dist/img/user3-128x128.jpg')}}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{asset('dist/img/user3-128x128.jpg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <!-- Sidebar -->
       @include('layouts.sidebar')
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- /.content -->
        @yield('content', 'Default Content')
    </div>
    <!-- /.content-wrapper -->
   @include('layouts.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 rtl -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('plugins/jqvmap/maps/jquery.vmap.world.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"></script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>


    function myFunction(){

        var baseAmount = parseFloat(document.getElementById("baseAmount").value);

        var result = baseAmount;

        sum = parseFloat(result).toFixed(2);

        document.getElementById("totalAmount").value = sum;

    }






    $(document).ready(function () {
        wallets();
        orders();


        function wallets(){
            $.ajax({
                type:"GET",
                url:"{{route('wallets')}}",
                dataType:"json",
                success: function (response) {
                    //console.log(response.data)
                    $('#wallets').html("");
                    $.each(response.wallets ,function (key ,item) {
                        $('#wallets').append('<tr>\
                                       <td>'+item.id+'</td>\
                                       <td>'+item.walletName+'</td>\
                                       <td>'+(item.attachWallet == null ? '<img src="{{asset('images/s.png')}}" alt="Girl in a jacket" width="120" height="60">' : '<img src="/images/wallet/'+item.attachWallet+'" alt="Girl in a jacket" width="120" height="60">')+'</td>\
                                       <td>'+item.baseAmount+'</td>\
                                       <td>'+item.totalAmount+'</td>\
                                       <td>'+item.highestAmountCanWithdrawn+'</td>\
                                       <td>'+item.bank.bankName+'</td>\
                                       <td>'+(item.status == 0 ? '<span class="badge bg-danger">غير فعالة</span>':'<span class="badge bg-success">فعالة</span>')+'</td>\
                                       <td >'+(item.status == 0 ? '':'<button type="button" class="btn btn-danger deleteWallet"  value="'+item.id+'" data-whatever="@mdo">اغلاق المحفظة</button> <a class="btn btn-warning" href="{{url('/create/withdraw/')}}/'+item.id+'" >سحب مبلغ </a> <a class="btn btn-success" href="{{url('/create/cash/')}}/'+item.id+'" >اضافة مبلغ </a>')+' <a class="btn btn-primary" href="{{url('/display/wallet/')}}/'+item.id+'" >عرض البيانات </a> </td>\
                                          </tr>');
                    });
                }
            });
        }

        function orders(){
            $.ajax({
                type:"GET",
                url:"{{route('ordersTable')}}",
                dataType:"json",
                success: function (response) {
                    //console.log(response.data)
                    $('#orders').html("");
                    $.each(response.orders ,function (key ,item) {
                        $('#orders').append('<tr>\
                                       <td>'+item.id+'</td>\
                                       <td>'+item.projectName+'</td>\
                                       <td>'+item.projectType+'</td>\
                                       <td>'+item.beneficiaryName+'</td>\
                                       <td>'+item.idNumber+'</td>\
                                       <td>'+item.phone+'</td>\
                                       <td>'+(item.orderCase == 'قيد الدراسة' ? '<span class="badge bg-warning">قيد الدراسة</span>':item.orderCase == 'مرفوض' ? '<span class="badge bg-danger">مرفوض</span>':'<span class="badge bg-success">مقبول</span>')+'</td>\
                                       <td>'+(item.paymentCase == 0 ? '<span class="badge bg-danger">غير مدفوع</span>':'<span class="badge bg-success">مدفوع</span>')+'</td>\
                                       <td>'+(item.wallet_id == null ? '--':item.wallet.walletName)+'</td>\
                                       <td>'+item.projectAmount+'</td>\
                                       <td>'+item.repaymentFinancingAmountMonths+'</td>\
                                       <td>'+item.orderDate+'</td>\
                                       <td >'+(item.orderCase == 'قيد الدراسة' ? '<button class="btn btn-success accept" value="'+item.id+'" >قبول</button> <button type="button" class="btn btn-warning rejected"  value="'+item.id+'" data-whatever="@mdo">رفض</button> ':item.orderCase == 'مقبول' && item.paymentCase == 0 ? '<button type="button" class="btn btn-info payment_order"  value="'+item.id+'" data-whatever="@mdo">تعين محفظة </button>':'')+'<button class="btn btn-danger deleteOrder" value="'+item.id+'" >حذف</button> '+'</td>\
                                          </tr>');
                    });
                }
            });
        }

        $(document).on('click', '.deleteWallet', function () {
            var wallet_id = $(this).val();
            $('#exampleModal').modal('show');
            $('#wallet_id').val(wallet_id);
        });

        $("#addWallet").validate({
            rules: {
                baseAmount: {
                    required: true,
                    number: true,
                    rangelength: [0, 20],

                },highestAmountCanWithdrawn: {
                    required: true,
                    number: true,
                    rangelength: [0, 20],

                },totalAmount: {
                    required: true,
                    number: true,
                    rangelength: [0, 20],

                },
                banks_id: {
                    required: true,
                },
                walletName: {
                    required: true,
                    maxlength: 40,
                  //  string: true,
                }
            },
            messages: {
                baseAmount: {
                    rangelength: "قيمة غير صالحة ",
                    required: "المبلغ الأساسي مطلوب",
                    digits: "يرجى ادخال ارقام فقط"
                } ,
                totalAmount: {
                    rangelength: "قيمة غير صالحة ",
                    required: "المبلغ الإجمالي مطلوب",
                    digits: "يرجى ادخال ارقام فقط"
                } ,
                highestAmountCanWithdrawn: {
                    rangelength: "قيمة غير صالحة ",
                    required: "أعلى مبلغ مطلوب",
                    digits: "يرجى ادخال ارقام فقط"
                } ,
                banks_id: {
                    required: "يرجى ادخال البنك ",
                },
                walletName: {
                    required: "اسم المحفظة مطلوب",
                    maxlength: "الاسم لا يتجاوز الاربيعين حرف",
                  //  string: "يرجى ادخال نصوص فقط",
                }

            },submitHandler: function(form) {

                var formData = new FormData($('#addWallet')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('storeWallet')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if (data.status == 400) {
                            $('#display_error').html("");
                            $('#display_error').addClass('alert alert-danger');
                            $.each(data.errors, function (key, err_value) {
                                $('#display_error').append('<li >' + err_value + '</li>');
                            });
                        }
                        else if(data.status == 200){

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#addWallet').find('input').val('');
                            $('#display_error').hide();

                        }else {
                            $('#addWallet').find('input').val('');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }


                });

            }




        });

        $("#addCashForm").validate({
            rules: {
                additionAmount: {
                    required: true,
                    digits: true,
                    rangelength: [0, 20],

                },additionDate: {
                    required: true,

                },reason: {
                    required: true,
                    rangelength: [20, 150],

                },
                attachFile: {
                    required: true,
                },

            },
            messages: {
                additionAmount: {
                    rangelength: "قيمة غير صالحة ",
                    required: "المبلغ الأساسي مطلوب",
                    digits: "يرجى ادخال ارقام فقط"
                } ,
                additionDate: {
                    required: "يرجى ادخال التاريخ ",
                } ,
                reason: {
                    rangelength: "يرجى توضيح الاسباب في اقل من خمسون حرف ",
                    required: "يرجى توضيح الاسباب",
                } ,
                attachFile: {
                    required: "يرجى ادخال صورة توضيحية   ",
                },


            },submitHandler: function(form) {

                var formData = new FormData($('#addCashForm')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('storeCash')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if (data.status == 400) {
                            $('#display_error').html("");
                            $('#display_error').addClass('alert alert-danger');
                            $.each(data.errors, function (key, err_value) {
                                $('#display_error').append('<li >' + err_value + '</li>');
                            });
                        }
                        else if(data.status == 200){

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                            $('#additionAmount').val('');
                            $('#reason').val('');
                            $('#attachFile').val('');
                            $('#display_error').hide();
                        }else {
                            location.reload();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }


                });

            }




        });

        $("#withdrawFormData").validate({

            rules: {
                withdrawAmount: {
                    required: true,
                    digits: true,
                    rangelength: [0, 20],

                },withdrawDate: {
                    required: true,

                },reason: {
                    required: true,
                    rangelength: [20, 150],

                },
                attachFile: {
                    required: true,
                },

            },
            messages: {
                withdrawAmount: {
                    rangelength: "قيمة غير صالحة ",
                    required: "المبلغ الأساسي مطلوب",
                    digits: "يرجى ادخال ارقام فقط"
                } ,
                withdrawDate: {
                    required: "يرجى ادخال التاريخ ",
                } ,
                reason: {
                    rangelength: "يرجى توضيح الاسباب في اقل من خمسون حرف ",
                    required: "يرجى توضيح الاسباب",
                } ,
                attachFile: {
                    required: "يرجى ادخال صورة توضيحية   ",
                },


           },
            submitHandler: function(form) {

                var formData = new FormData($('#withdrawFormData')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('storeWithdraw')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if (data.status == 200) {
                            $('#display_error').html("");
                            $('#display_error').addClass('alert alert-danger');
                            $.each(data.errors, function (key, err_value) {
                                $('#display_error').append('<li >' + err_value + '</li>');
                            });
                        }
                        else if(data.status == 400){

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#withdrawAmount').val('');
                            $('#reason').val('');
                            $('#attachFile').val('');
                            $('#display_error').hide();
                          //  location.reload();
                        }else {

                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }


                });

            }




        });

        $("#addOrder").validate({
            rules: {
                idNumber: {
                    required: true,
                    digits: true,
                    rangelength: [9, 9],

                }, projectType: {
                    required: true,
                },
                phone: {
                    required: true,
                    digits: true,
                    rangelength: [7, 10],

                },projectAmount: {
                    required: true,
                    number: true,
                    rangelength: [0, 20],

                },expectedProfit: {
                    required: true,
                    number: true,
                    rangelength: [0, 20],

                },repaymentFinancingAmountMonths: {
                    required: true,
                    rangelength: [0, 40],

                },
                orderDate: {
                    required: true,
                },projectType: {
                    required: true,
                },
                projectName: {
                    required: true,
                    maxlength: 40,
                    //  string: true,
                },
                beneficiaryName: {
                    required: true,
                    maxlength: 40,
                    //  string: true,
                }
            },
            messages: {
                idNumber: {
                    rangelength: "قيمة غير صالحة ",
                    required: "رقم الهوية مطلوب",
                    digits: "يرجى ادخال ارقام فقط"
                } ,  projectType: {
                    required: "يرجى اختيار نوع المشروع",
                } ,
                phone: {
                    rangelength: "قيمة غير صالحة ",
                    required: "رقم الجوال مطلوب",
                    digits: "يرجى ادخال ارقام فقط"
                } ,
                projectAmount: {
                    rangelength: "قيمة غير صالحة ",
                    required: "مبلغ المشروع مطلوب",
                    number: "يرجى ادخال ارقام فقط"
                } ,
                expectedProfit: {
                    rangelength: "قيمة غير صالحة ",
                    required: "مبلغ الربح المتوقع مطلوب",
                    number: "يرجى ادخال ارقام فقط"
                } ,
                repaymentFinancingAmountMonths: {
                    required: "مدة تسديد مبلغ التمويل مطلوب",
                    rangelength: "قيمة غير صالحة ",
                }, projectName: {
                    required: "اسم المشروع مطلوب",
                    rangelength: "قيمة غير صالحة ",
                },beneficiaryName: {
                    required: "اسم المستفيد مطلوب",
                    rangelength: "قيمة غير صالحة ",
                },
                orderDate: {
                    required: "تاريخ الطلب مطلوب",

                }

            },submitHandler: function(form) {

                var formData = new FormData($('#addOrder')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: "{{route('storeOrder')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if (data.status == 400) {
                            $('#display_error').html("");
                            $('#display_error').addClass('alert alert-danger');
                            $.each(data.errors, function (key, err_value) {
                                $('#display_error').append('<li >' + err_value + '</li>');
                            });
                        }
                        else if(data.status == 200){

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#addWallet').find('input').val('');
                            $('#display_error').hide();

                        }else {
                            $('#addWallet').find('input').val('');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }


                });

            }




        });

        $(document).on('click', '.accept', function () {
            var id = $(this).val();

            $.ajax({
                type: 'GET',
                url: "accept/order/"+id,

                success: function (data) {
                   if(data.status == 200){
                       orders();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }


            });

        });

        $(document).on('click', '.rejected', function () {
            var order_id = $(this).val();
            $('#exampleModal').modal('show');
            $('#order_id').val(order_id);
        });

        $(document).on('click', '.payment_order', function () {
            var orderr_id = $(this).val();
            $('#WalletModal').modal('show');
            $('#orderr_id').val(orderr_id);
        });

        $("#rejectedOrder").validate({
            rules: {
                reason: {
                    required: true,
                    rangelength: [20, 150],

                }
            },
            messages: {
                reason: {
                    rangelength: "الاسباب غير كافية ",
                    required: "يجب ادخال الاسباب",
                } ,


            },submitHandler: function(form) {

                var formData = new FormData($('#rejectedOrder')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: "{{route('rejectedOrder')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if (data.status == 400) {
                            $('#display_error').html("");
                            $('#display_error').addClass('alert alert-danger');
                            $.each(data.errors, function (key, err_value) {
                                $('#display_error').append('<li >' + err_value + '</li>');
                            });
                        }
                        else if(data.status == 200){
                            orders();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#reason').val('');
                            $('#exampleModal').modal('hide');
                            $('#display_error').hide();

                        }else {
                            orders();
                            $('#rejectedOrder').find('input').val('');
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }


                });

            }




        });

        $("#payment_Order").validate({
            rules: {
                wallet_id: {
                    required: true,
                }, order_id: {
                    required: true,
                }
            },
            messages: {
                wallet_id: {
                    required: "قم باختيار المحفظة",
                } ,
            },submitHandler: function(form) {

                var formData = new FormData($('#payment_Order')[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: "{{route('paymentOrder')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if (data.status == 400) {
                            $('#display_error').html("");
                            $('#display_error').addClass('alert alert-danger');
                            $.each(data.errors, function (key, err_value) {
                                $('#display_error').append('<li >' + err_value + '</li>');
                            });
                        }
                        else if(data.status == 200){
                            orders();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })

                            $('#WalletModal').modal('hide');
                            $('#display_error').hide();

                        }else {
                            orders();
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: data.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }


                });

            }




        });

        $(document).on('click', '.deleteOrder', function () {
            var id = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'DELETE',
                url: "delete/order/"+id,

                success: function (data) {
                    if(data.status == 200){
                        orders();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }


            });

        });

    });
</script>

</body>
</html>
