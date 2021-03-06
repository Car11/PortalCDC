<?php
if (!isset($_SESSION))
    session_start();
    include_once('class/Globals.php');
    // Sesion de usuario
    require_once("../class/Sesion.php");
    $sesion = new Sesion();
    if (!$sesion->estado){        
        $_SESSION['url']= explode('/',$_SERVER['REQUEST_URI'])[2]; //indexar a 1 cuando el sitio este en la raiz
        header('Location: ../Login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- check User session -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- <script src="assets/js/Session.min.js"></script> -->
    <!-- <script>Session.Check();</script> -->
    <!-- /End check -->
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inspección CDC</title>

    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/css/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="assets/css/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="assets/css/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- SweetAlert -->
    <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
    <!-- Datatables Export-->
    <link href="assets/css/datatables.net-bs/css/buttons.dataTables.min.css" rel="stylesheet">
    <!-- Select -->
    <link href="assets/css/bootstrap-select.css" rel="stylesheet">
    
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="assets/css/custom.css" rel="stylesheet">
    <!-- Bootstrap Toggle -->        
    <link href="assets/css/bootstrap-toggle.min.css" rel="stylesheet">

</head>

<body class="nav-md">
    <div class="container body">
        <!-- <div class="main_container" style="visibility:hidden"> -->
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title">
                            
                            <span>Entrega de Turno</span>
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <!-- <img src="" alt="..." class="img-circle profile_img"> -->
                        </div>
                        <div class="profile_info">
                            <span>Bienvenido,</span>
                            <h2 id='call_name'></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-folder"></i> Inspección <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="entregaTurno.html.html">Entrega de Turno</a></li>
                                        <li><a href="inspeccion.html">Inspección</a></li>
                                        <li><a href="historial.html">Historial</a></li>
                                    </ul>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle">
                                <i class="fa fa-bars"></i>
                            </a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" id='call_username'>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li>
                                        <a onclick="Session.End();">
                                            <i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div>
                            <h3>ENTREGA DE TURNO CDC SABANA</h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    
                                    
                                    <div class="clearfix"></div>
                                </div>

                                <!--  CONTENIDO DE LA PAGINA -->
                                <div class="x_content">
                                    <!-- TABLE -->
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table id="tblEntregaTurno" class="table display responsive table-striped jambo_table no-wrap" width="100%" aria-describedby="datatable_info">
                                                    <tbody id="tableBody-EntregaTurno">
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <button type="button" id="btnIniciaInspeccion" class="btn btn-success"
                                                    style=" width: -webkit-fill-available;">Iniciar Inspección </button>
                                            </div>
                                        </div>
                                    
                                    <!-- /TABLE -->

                                    <!-- MODAL -->
                                    <div class="modal fade modalDetalleReporte" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Detalle del Reporte</h4>
                                                </div>

                                                <div class="modal-body">
                                                    <form class="form-horizontal form-label-left" id="frmDetalleReporte" novalidate>

                                                    <div class="item form-group">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <textarea id="txtDetalleReporte" class="form-control" name="txtDetalleReporte" required="required" type="text" placeholder="Ingrese Detalle del Reporte"
                                                                    style="width:100%;height: 200px;" autofocus></textarea>
                                                            </div>
                                                    </div>
            
                                                    </form>
                                                    <div class="ln_solid"></div>
                                                        <div class="form-group">
                                                            <div class="col-md-6 col-md-offset-3">
                                                                <button type="button" class="btn btn-default" id="btnCerrarModal">Cerrar</button>
                                                                <button class="btn btn-default" id="btnGuardarReporte" class="btn">Aceptar</button>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="modal-footer">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /modal -->

                                </div>
                                <!--  /CONTENIDO DE LA PAGINA -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Instituto Costarricense de Electricidad
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

   <!-- Bootstrap -->
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <!-- FastClick -->
   <script src="assets/js/fastclick/lib/fastclick.js"></script>
   <!-- NProgress -->
   <script src="assets/js/nprogress/nprogress.js"></script>
   <!-- Moment -->
   <script src="assets/js/moment.min.js"></script>
   <script src="assets/js/moment-timezone.js"></script>
   <!-- bootstrap-datetimepicker -->
   <script src="assets/js/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
   <!-- Validator -->
   <script src="assets/js/validator.min.js"></script>
   <!-- Input mask -->
   <script src="assets/js/jquery.inputmask/jquery.inputmask.bundle.min.js"></script>
   <!-- JS Scripts -->
   <script src="assets/js/inspeccion.js"></script>
   <!-- Sweet Alert -->
   <script src="assets/js/sweetalert2.min.js"></script>
   <!-- Datatables -->
   <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
   <!-- iCheck -->
   <script src="assets/js/iCheck/icheck.min.js"></script>
   <!-- JS dataTables -->
   <script src="assets/js/jquery.dataTables.min.js"></script>
   <script src="assets/jquery.dataTables/dataTables.buttons.min.js"></script>
   <script src="assets/jquery.dataTables/buttons.flash.min.js"></script>
   <script src="assets/jquery.dataTables/jszip.min.js"></script>
   <script src="assets/jquery.dataTables/pdfmake.min.js"></script>
   <script src="assets/jquery.dataTables/vfs_fonts.js"></script>
   <script src="assets/jquery.dataTables/buttons.html5.min.js"></script>
   <script src="assets/jquery.dataTables/buttons.print.min.js"></script>
   <!-- FastClick -->
   <script src="../vendors/fastclick/lib/fastclick.js"></script>
   <!-- NProgress -->
   <script src="../vendors/nprogress/nprogress.js"></script>
   <!-- iCheck -->
   <script src="../vendors/iCheck/icheck.min.js"></script>
   <!-- Bootstrap Colorpicker -->
   <script src="assets/bootstrap/js/bootstrap-colorpicker.min.js"></script>
   <!-- Select -->
   <script src="assets/js/bootstrap-select.js"></script>
   <!-- Toggle -->
   <script src="assets/js/bootstrap-toggle.min.js"></script>
   <!-- Custom Theme Scripts -->
   <script src="assets/js/custom.min.js"></script>

</body>

</html>

<script>
    $(document).ready(function () {
        inspeccion.id=null;
        inspeccion.ReadEntregaTurno;

        $( "#btnIniciaInspeccion" ).click(function() {
            window.location.href = "/InspeccionCDC/inspeccion.html";
        });

    });

</script>