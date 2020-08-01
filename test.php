<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dynamic modal dialog form bootstrap</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
       <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-black">
       <?php include "layout/header.php" ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php //include "layout/left_sidebar.php" ?>
            <aside class="right-side">
                <section class="content-header">
                    <h1>
                      How to create Dynamic modal dialog form bootstrap
                    </h1>
                </section>
                <section class="content" >
                 <div class="box box-primary">
                <div class="row">
                   <div class="col-md-2">
                        <select class="form-control" id="mysize">
                          <option value="small">Small</option>
                          <option value="standart">Standart</option>
                          <option value="large">Large</option>
                        </select>
                    </div>
                </div><br/>
 
                 <div class="row">
                   <div class="col-md-4">
<button type="button" class="btn btn-primary btn-lg" onClick="open_container();" > Launch demo modal</button>
                    </div>
                </div>
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                      </div>
                      <div class="modal-body" id="modal-bodyku">
                      </div>
                      <div class="modal-footer" id="modal-footerq">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end of modal ------------------------------>
               </div> 
 
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <script src="../js/jquery.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="../js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
    </body>
</html>