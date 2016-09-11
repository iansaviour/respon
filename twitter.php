<?php  
  include 'includes/core.php';
  include 'includes/top.php';

  $query = "SELECT * FROM tb_option_twitter";
  $result = mysqli_query($id_mysql,$query);
  $data = mysqli_fetch_array($result);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Twitter
      <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Twitter</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-8 col-xs-12">
        <!-- alert -->
        <div class="alert alert-info" id="alertInfo" style="display:none;">
          <h4><i class="icon fa fa-info-circle"></i> Information</h4>
          <span id="alertInfoBody">Info alert preview. This alert is dismissable.</span>
        </div>
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Configuration</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" id="formControl" style="font-size:13px;">
            <div class="box-body">
              <div class="form-group">
                <label for="inputConsumerKey" class="col-sm-2 control-label">Consumer Key</label>
                <div class="col-sm-10">
                  <input type="text" value="<?php echo $data['consumer_key'] ?>" class="form-control" id="inputConsumerKey" placeholder="Consumer Key" name="txtConsumerKey">
                </div>
              </div>
              <div class="form-group">
                <label for="inputConsumerSecret" class="col-sm-2 control-label">Consumer Secret</label>
                <div class="col-sm-10">
                  <input type="text" value="<?php echo $data['consumer_secret'] ?>" class="form-control" id="inputConsumerSecret" placeholder="Consumer Secret" name="txtConsumerSecret">
                </div>
              </div>
              <div class="form-group">
                <label for="inputOauthToken" class="col-sm-2 control-label">Oauth Token</label>
                <div class="col-sm-10">
                  <input type="text" value="<?php echo $data['oauth_token'] ?>" class="form-control" id="inputOauthToken" placeholder="Oauth Token" name="txtOauthToken">
                </div>
              </div>
              <div class="form-group">
                <label for="inputOAuthTokenSecret" class="col-sm-2 control-label">Oauth Token Secret</label>
                <div class="col-sm-10">
                  <input type="text" value="<?php echo $data['oauth_token_secret'] ?>" class="form-control" id="inputOAuthTokenSecret" placeholder="Oauth Token Secret" name="txtOauthTokenSecret">
                </div>
              </div>
              <div class="form-group">
                <label for="inputReloadInterval" class="col-sm-2 control-label">Reload Interval</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" value="<?php echo $data['reload_interval']/1000 ?>" id="inputReloadInterval" name="txtReloadInterval" class="form-control">
                    <div class="input-group-addon">
                      second
                    </div>
                  </div><!-- /.input group -->
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <button style="margin-left:5px;" id="btnSave" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-save"></i> Save Changes</span></button>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.box -->
      </div><!-- /.col -->

      <div class="col-lg-4 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Service</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body body-service">
            <ul class="products-list product-list-in-box" id="ulService">
              <div id="appendList1">
                
              </div>

              <li class="item list-service" style="border-top:0px;">
                <div class="text-danger head-icon-service">
                  <i class="fa fa-power-off"></i>
                </div>
                <div class="product-info text-danger">
                  <div><b>Service isn't running</b>  <div>
                  <span class="product-description-">
                    Service isn't running for this time.
                  </span>
                </div>
              </li><!-- /.item -->
            </ul>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button id="startService" type="button" class="btn btn-success pull-right ladda-button" data-color="green" data-size="xs"><span class="ladda-label"><i class="fa fa-play-circle"></i> Start Service</span></button>
            <button style="display:none;" id="stopService" type="button" class="btn btn-success pull-right ladda-button" data-color="red" data-size="xs"><span class="ladda-label"><i class="fa fa-stop"></i> Stop Service</span></button>
          </div><!-- /.box-footer -->
        </div>
      </div>
    </div><!-- /.row -->

    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Monitoring Data</h3>
            <div class="box-tools pull-right">
              <button type="button" id="btn-refresh" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i>&nbsp; Refresh</button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul id="myTabs" class="nav nav-tabs" role="tablist"> 
              <li role="presentation" class="active"><a href="#received" id="received-tab" role="tab" data-toggle="tab" aria-controls="received" aria-expanded="true">Received</a></li> 
              <li role="presentation" class=""><a href="#sent" role="tab" id="sent-tab" data-toggle="tab" aria-controls="tab" aria-expanded="false">Sent</a></li>
            </ul>
            <div id="myTabContent" class="tab-content"> 
              <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
                <table class="table table-striped" id="example" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Id Inbox</th>
                      <th>User Id</th>
                      <th>From</th>
                      <th>Date</th>
                      <th>Inbox</th>
                    </tr>
                  </thead>
                </table>
              </div> 
              <div style="padding-top:15px;" role="tabpanel" class="tab-pane fade" id="sent" aria-labelledby="sent-tab"> 
                <table class="table table-striped" id="example2" class="display" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Id Outbox</th>
                      <th>To</th>
                      <th>Date</th>
                      <th>Outbox</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div><!-- /.box-body -->
        </div>
      </div>
    </div><!-- /.row -->

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">
  var i = 1;
  var intv;
  var intv_s= 0;
  var is_received_tab = true;
  
  function callAPI(){
    //clear
    //clearInterval(intv);

    //get
    var jqXHR = $.ajaxq('MyQueue', {
      url: 'svc/twitter/examples/get_msg.php',
      beforeSend: function() {
         
      },
      error: function() {
        console.log("error");
      },
      complete: function() {
        console.log("complete");
      },
      success: function(data) {
        console.log("success");
        $("#ulService").append('<li class="list-service"> '+
                              '<div class="text-info head-icon-service"> '+
                                '<i class="fa fa-exclamation-circle"></i> '+
                              '</div> '+
                              '<div class="product-info text-info"> '+
                                '<div><b>Log Service</b><div> '+
                                '<span class="product-description-"> '+
                                  ''+data+''+
                                '</span> '+
                              '</div> '+
                            '</li>');
        $("#example").DataTable().ajax.reload();
        $("#example2").DataTable().ajax.reload();
      }
    });
  }

  function getInterval(){
    $.ajax({
      url: 'twitter_act.php?t=2',
      async : false
    })
    .done(function(data) {
      intv_s = data
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    
  }

  $(document).ready(function() {
    getInterval();

    $("#btnSave").click(function(event) {
      var l = Ladda.create( document.querySelector( '#btnSave' ) );
      l.start();
      $.ajax({
        url: 'twitter_act.php?t=1',
        type: 'POST',
        data: $("#formControl").serialize()
      })
      .done(function(data) {
        console.log(data);
        l.stop();
        $("#alertInfoBody").html(data);
        $("#alertInfo").fadeIn("slow");
        setTimeout(function() {$("#alertInfo").fadeOut("slow");}, 3000);
        getInterval();
      })
      .fail(function() {
        console.log("error");
      })
      .always(function() {
        console.log("complete");
      });
    });

    $("#startService").click(function(event) {
      $(this).hide();
      $("#stopService").show();
      $("#ulService").append('<li class="list-service"> '+
                                '<div class="text-success head-icon-service"> '+
                                  '<i class="fa fa-play"></i> '+
                                '</div> '+
                                '<div class="product-info text-success"> '+
                                  '<div><b>Service is running</b>  <div> '+
                                  '<span class="product-description-"> '+
                                    'Service has started. '+
                                  '</span> '+
                                '</div> '+
                              '</li>');
      callAPI();
      intv = setInterval(function() {callAPI()}, intv_s);
      i++;
    });

    $("#stopService").click(function(event) {
      $.ajaxq.abort('MyQueue');
      $.ajaxq.clear('MyQueue');
      clearInterval(intv);
      
      $(this).hide();
      $("#startService").show();
      $("#ulService").append('<li class="item list-service"> '+
                              '<div class="text-danger head-icon-service"> '+
                                '<i class="fa fa-power-off"></i> '+
                              '</div> '+
                              '<div class="product-info text-danger"> '+
                                '<div><b>Stop Service</b>  <div> '+
                                '<span class="product-description-"> '+
                                  'Service has been stopped. '+
                                '</span> '+
                              '</div> '+
                            '</li>');
      i++;
    });

    $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "twitter_act.php?t=3",
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            },
            {
                "targets": [ 1 ],
                "visible": false
            }
        ]
    } );

     $('#example2').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "twitter_act.php?t=4",
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            },
        ]
    } );

    $("#btn-refresh").click(function(event) {
      if (is_received_tab) {
        $("#example").DataTable().ajax.reload();
      } else{
        $("#example2").DataTable().ajax.reload();
      };
    });

    $('.nav-tabs a').click(function (e) {
         //e.preventDefault();
         if ($($(this).attr('href')).index()==0) {
            is_received_tab = true;
         } else{
            is_received_tab = false;
         };
    });

  });
</script>