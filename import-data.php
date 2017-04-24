<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.2
 * @link http://coreui.io
 * Copyright (c) 2017 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword"
          content="Bootstrap,Admin,Template,Open,Source,AngularJS,Angular,Angular2,jQuery,CSS,HTML,RWD,Dashboard">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>CoreUI - Open Source Bootstrap Admin Template</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">

</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-compact'				- Compact Sidebar Navigation (Only icons)

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Footer options
1. 'footer-fixed'						- Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button">☰</button>
    <!--   <a class="navbar-brand" href="#"></a>-->
    <ul class="nav navbar-nav hidden-md-down">
        <li class="nav-item">
            <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
        </li>

        <li class="nav-item px-1">
            <a class="nav-link" href="dashboard.html">Home</a>
        </li>
        <li class="nav-item px-1">
            <a class="nav-link" href="#">About</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
               aria-haspopup="true" aria-expanded="false">
                <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                <span class="hidden-md-down">admin</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>
                <a class="dropdown-item" href="#"><i class="fa fa-lock"></i> Logout</a>
            </div>
        </li>
        <!-- <li class="nav-item hidden-md-down">
             <a class="nav-link navbar-toggler aside-menu-toggler" href="#">☰</a>
         </li>-->
    </ul>
</header>

<div class="app-body">
<!--    <div class="sidebar">-->
<!--        <nav class="sidebar-nav">-->
<!--            <ul class="nav">-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="dashboard.html"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-info">NEW</span></a>-->
<!--                </li>-->
<!---->

<!--                <li class="nav-title">-->
<!--                    Menu-->
<!--                </li>-->
<!--                <li class="nav-item nav-dropdown">-->
<!--                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-puzzle"></i> Data Collect</a>-->
<!--                    <ul class="nav-dropdown-items">-->
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link" href="components-forms.html"><i class="icon-puzzle"></i> Forms</a>-->
<!--                        </li>-->
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link" href="import-data.php"><i class="icon-puzzle"></i> Import Data</a>-->
<!--                        </li>-->
<!---->
<!--                    </ul>-->
<!--                </li>-->
<!--                <li class="nav-item nav-dropdown">-->
<!--                    <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-star"></i> Data Mining</a>-->
<!--                    <ul class="nav-dropdown-items">-->
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link" href="icons-font-awesome.html"><i class="icon-star"></i> Proses</a>-->
<!--                        </li>-->
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link" href="icons-simple-line-icons.html"><i class="icon-star"></i> Hasil</a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
<!--                <li class="divider"></li>-->
<!--                <li class="nav-title">-->
<!--                    Account-->
<!--                </li>-->
<!--                <!--  <li class="nav-item nav-dropdown">-->
<!--                      <a class="nav-link" href="#"><i class="icon-star"></i> Logout</a>-->
<!--                  </li>-->
<!---->
<!--            </ul>-->
<!--        </nav>-->
<!--    </div>-->
    <?php
    //koneksi ke database
    require "koneksi.php";
    //memanggil file excel_reader
    require "excel_reader.php";


    if(isset($_POST['submit'])){

        $target = basename($_FILES['data']['name']) ;
        move_uploaded_file($_FILES['data']['tmp_name'], $target);
        chmod($_FILES['data']['name'],0777);
        $data = new Spreadsheet_Excel_Reader($_FILES['data']['name'],false);
        $baris = $data->rowcount($sheet_index=0);


        $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
        if($drop == 1){

            $truncate ="TRUNCATE TABLE barang";
            mysql_query($truncate);
        };

        for ($i=2; $i<=$baris; $i++)
        {
            $nama_barang    = $data->val($i, 1);
            $faktur_penjualan   = $data->val($i, 2);
            $jumlah_barang  = $data->val($i, 3);

            $query = "INSERT into barang (nama_barang,faktur_penjualan,jumlah_barang)values('$nama_barang','$faktur_penjualan','$jumlah_barang')";
            $hasil = mysql_query($query);
        }

        if(!$hasil){
            die(mysql_error());
        }else{
            echo "<div class='alert alert-success'>Data berhasil diimpor.</div>";
        }

        unlink($_FILES['data']['name']);
    }
    ?>
    <!-- Main content -->
    <main class="main">


        <ol class="breadcrumb">
            <li class="breadcrumb-item" href="dashboard.html">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a>
            </li>
            <li class="breadcrumb-item active">Import</li>
        </ol>

        <div class="container-fluid">
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-header">
                        <strong>Form</strong>p
                        <small>Data Import</small>
                    </div>
                    <div class="card-block">
                        <form onSubmit="return validateForm()" action="import-data.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="company">Import File </label>
                            <br>
                            <input type="file" id="data" name="data">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-md btn-primary save-right" name="submit"><i
                                class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-md btn-danger save-right"><i class="fa fa-ban"></i> Reset
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.conainer-fluid -->
    </main>

    <!--  <aside class="aside-menu">
          <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab"><i class="icon-list"></i></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#messages" role="tab"><i class="icon-speech"></i></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#settings" role="tab"><i class="icon-settings"></i></a>
              </li>
          </ul>

          &lt;!&ndash; Tab panes &ndash;&gt;
          &lt;!&ndash;<div class="tab-content">
              <div class="tab-pane active" id="timeline" role="tabpanel">
                  <div class="callout m-0 py-h text-muted text-center bg-faded text-uppercase">
                      <small><b>Today</b>
                      </small>
                  </div>
                  <hr class="transparent mx-1 my-0">
                  <div class="callout callout-warning m-0 py-1">
                      <div class="avatar float-right">
                          <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                      </div>
                      <div>Meeting with
                          <strong>Lucas</strong>
                      </div>
                      <small class="text-muted mr-1"><i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                      <small class="text-muted"><i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
                  </div>
                  <hr class="mx-1 my-0">
                  <div class="callout callout-info m-0 py-1">
                      <div class="avatar float-right">
                          <img src="img/avatars/4.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                      </div>
                      <div>Skype with
                          <strong>Megan</strong>
                      </div>
                      <small class="text-muted mr-1"><i class="icon-calendar"></i>&nbsp; 4 - 5pm</small>
                      <small class="text-muted"><i class="icon-social-skype"></i>&nbsp; On-line</small>
                  </div>
                  <hr class="transparent mx-1 my-0">
                  <div class="callout m-0 py-h text-muted text-center bg-faded text-uppercase">
                      <small><b>Tomorrow</b>
                      </small>
                  </div>
                  <hr class="transparent mx-1 my-0">
                  <div class="callout callout-danger m-0 py-1">
                      <div>New UI Project -
                          <strong>deadline</strong>
                      </div>
                      <small class="text-muted mr-1"><i class="icon-calendar"></i>&nbsp; 10 - 11pm</small>
                      <small class="text-muted"><i class="icon-home"></i>&nbsp; creativeLabs HQ</small>
                      <div class="avatars-stack mt-h">
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/2.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/3.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/4.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/5.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                      </div>
                  </div>
                  <hr class="mx-1 my-0">
                  <div class="callout callout-success m-0 py-1">
                      <div>
                          <strong>#10 Startups.Garden</strong>Meetup</div>
                      <small class="text-muted mr-1"><i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                      <small class="text-muted"><i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
                  </div>
                  <hr class="mx-1 my-0">
                  <div class="callout callout-primary m-0 py-1">
                      <div>
                          <strong>Team meeting</strong>
                      </div>
                      <small class="text-muted mr-1"><i class="icon-calendar"></i>&nbsp; 4 - 6pm</small>
                      <small class="text-muted"><i class="icon-home"></i>&nbsp; creativeLabs HQ</small>
                      <div class="avatars-stack mt-h">
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/2.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/3.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/4.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/5.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                          <div class="avatar avatar-xs">
                              <img src="img/avatars/8.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                          </div>
                      </div>
                  </div>
                  <hr class="mx-1 my-0">
              </div>
              <div class="tab-pane p-1" id="messages" role="tabpanel">
                  <div class="message">
                      <div class="py-1 pb-3 mr-1 float-left">
                          <div class="avatar">
                              <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                              <span class="avatar-status badge-success"></span>
                          </div>
                      </div>
                      <div>
                          <small class="text-muted">Lukasz Holeczek</small>
                          <small class="text-muted float-right mt-q">1:52 PM</small>
                      </div>
                      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                      <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                  </div>
                  <hr>
                  <div class="message">
                      <div class="py-1 pb-3 mr-1 float-left">
                          <div class="avatar">
                              <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                              <span class="avatar-status badge-success"></span>
                          </div>
                      </div>
                      <div>
                          <small class="text-muted">Lukasz Holeczek</small>
                          <small class="text-muted float-right mt-q">1:52 PM</small>
                      </div>
                      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                      <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                  </div>
                  <hr>
                  <div class="message">
                      <div class="py-1 pb-3 mr-1 float-left">
                          <div class="avatar">
                              <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                              <span class="avatar-status badge-success"></span>
                          </div>
                      </div>
                      <div>
                          <small class="text-muted">Lukasz Holeczek</small>
                          <small class="text-muted float-right mt-q">1:52 PM</small>
                      </div>
                      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                      <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                  </div>
                  <hr>
                  <div class="message">
                      <div class="py-1 pb-3 mr-1 float-left">
                          <div class="avatar">
                              <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                              <span class="avatar-status badge-success"></span>
                          </div>
                      </div>
                      <div>
                          <small class="text-muted">Lukasz Holeczek</small>
                          <small class="text-muted float-right mt-q">1:52 PM</small>
                      </div>
                      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                      <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                  </div>
                  <hr>
                  <div class="message">
                      <div class="py-1 pb-3 mr-1 float-left">
                          <div class="avatar">
                              <img src="img/avatars/7.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
                              <span class="avatar-status badge-success"></span>
                          </div>
                      </div>
                      <div>
                          <small class="text-muted">Lukasz Holeczek</small>
                          <small class="text-muted float-right mt-q">1:52 PM</small>
                      </div>
                      <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                      <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
                  </div>
              </div>
              <div class="tab-pane p-1" id="settings" role="tabpanel">
                  <h6>Settings</h6>

                  <div class="aside-options">
                      <div class="clearfix mt-2">
                          <small><b>Option 1</b>
                          </small>
                          <label class="switch switch-text switch-pill switch-success switch-sm float-right">
                              <input type="checkbox" class="switch-input" checked="">
                              <span class="switch-label" data-on="On" data-off="Off"></span>
                              <span class="switch-handle"></span>
                          </label>
                      </div>
                      <div>
                          <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                      </div>
                  </div>

                  <div class="aside-options">
                      <div class="clearfix mt-1">
                          <small><b>Option 2</b>
                          </small>
                          <label class="switch switch-text switch-pill switch-success switch-sm float-right">
                              <input type="checkbox" class="switch-input">
                              <span class="switch-label" data-on="On" data-off="Off"></span>
                              <span class="switch-handle"></span>
                          </label>
                      </div>
                      <div>
                          <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                      </div>
                  </div>

                  <div class="aside-options">
                      <div class="clearfix mt-1">
                          <small><b>Option 3</b>
                          </small>
                          <label class="switch switch-text switch-pill switch-success switch-sm float-right">
                              <input type="checkbox" class="switch-input">
                              <span class="switch-label" data-on="On" data-off="Off"></span>
                              <span class="switch-handle"></span>
                          </label>
                      </div>
                  </div>

                  <div class="aside-options">
                      <div class="clearfix mt-1">
                          <small><b>Option 4</b>
                          </small>
                          <label class="switch switch-text switch-pill switch-success switch-sm float-right">
                              <input type="checkbox" class="switch-input" checked="">
                              <span class="switch-label" data-on="On" data-off="Off"></span>
                              <span class="switch-handle"></span>
                          </label>
                      </div>
                  </div>

                  <hr>
                  <h6>System Utilization</h6>

                  <div class="text-uppercase mb-q mt-2">
                      <small><b>CPU Usage</b>
                      </small>
                  </div>
                  <div class="progress progress-xs">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <small class="text-muted">348 Processes. 1/4 Cores.</small>

                  <div class="text-uppercase mb-q mt-h">
                      <small><b>Memory Usage</b>
                      </small>
                  </div>
                  <div class="progress progress-xs">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <small class="text-muted">11444GB/16384MB</small>

                  <div class="text-uppercase mb-q mt-h">
                      <small><b>SSD 1 Usage</b>
                      </small>
                  </div>
                  <div class="progress progress-xs">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <small class="text-muted">243GB/256GB</small>

                  <div class="text-uppercase mb-q mt-h">
                      <small><b>SSD 2 Usage</b>
                      </small>
                  </div>
                  <div class="progress progress-xs">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <small class="text-muted">25GB/256GB</small>
              </div>
          </div>&ndash;&gt;
      </aside>-->


</div>


<footer class="app-footer">
    <a href="http://github.com">Stock Prediction</a> © 2017 Nur Fitrina.
    <!-- <span class="float-right">Powered by <a href="http://coreui.io">CoreUI</a>
     </span>-->
</footer>

<!-- Bootstrap and necessary plugins -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/tether/dist/js/tether.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/pace/pace.min.js"></script>
<script type="text/javascript">
    //    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('filepegawaiall', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>

<!-- Plugins and scripts required by all views -->
<script src="bower_components/chart.js/dist/Chart.min.js"></script>


<!-- GenesisUI main scripts -->

<script src="js/app.js"></script>


</body>

</html>