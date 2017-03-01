<?php  
  include 'includes/core.php';
  include 'includes/top.php';
  //
  $id_contact_group = "";
  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
  }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Group Contact
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Group Contact</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- table contact -->
    <div class="row" id="panel-contact" style="display:none;">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-primary">
          <div class="box-body">
              
            <div style="padding-top:15px;"  role="tabpanel" class="tab-pane fade active in" id="received" aria-labelledby="received-tab"> 
              <table class="table table-striped" id="contact" class="display" cellspacing="0" width="100%" style="overflow-X: scroll;">
                <thead>
                  <tr>
                    <th>Id Contact</th>
                    <th>Contact Name</th>
                    <th>Id Contact</th>
                    <th>Member</th>
                    <th>Id Contact Group Det</th>
                    <th>Option</th>
                  </tr>
                </thead>
              </table>
            </div> 
          </div><!-- /.box-body -->
          <div class="box-footer">
            <button style="margin-left:5px;" id="btnBack" type="button" class="btn btn-info pull-right ladda-button" data-color="blue" data-size="xs" data-style="zoom-out"><span class="ladda-label"><i class="fa fa-arrow-left"></i> Back to contact group</span></button>
          </div><!-- /.box-footer -->
        </div>
      </div>
    </div><!-- /.row -->
    <!-- end table contact -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php  
  include 'includes/bottom.php';
?>
<script type="text/javascript">
$(document).ready(function() {
<?php
  $penanda = "''";
  if(isset($_GET['selCG'])){
    $id_contact_group = $_GET['selCG'];
    $penanda = "'?selCG=".$id_contact_group."'" ;
    ?>
    $('#contact').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "group_contact_add_act.php?t=contact&selCG=<?php echo $id_contact_group; ?>",
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            },
            {
                "targets": [ 3 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            }
        ]
    });
    $("#panel-contact").fadeIn('slow');
    $("#btnBack").click(function(event) {
      window.location="group_contact.php?selCG=<?php echo $id_contact_group; ?>";
    });
    <?php
  }

?>
});
</script>