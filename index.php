<?php

/**
 * @file
 *
 * Reads data from a Google Spreadsheet that needs authentication.
 */

require 'vendor/autoload.php';

/**
 * Set here the full path to the private key .json file obtained when you
 * created the service account. Notice that this path must be readable by
 * this script.
 */
$service_account_file = 'spreadsheet-340615-663420b3fc09.json';

/**
 * This is the long string that identifies the spreadsheet. Pick it up from
 * the spreadsheet's URL and paste it below.
 */
$spreadsheet_id = '1J7QXTVrIfg6-PFgKAgQCWqcVOEUa_Xb2vpCrltrP90g';

/**
 * This is the range that you want to extract out of the spreadsheet. It uses
 * A1 notation. For example, if you want a whole sheet of the spreadsheet, then
 * set here the sheet name.
 *
 * @see https://developers.google.com/sheets/api/guides/concepts#a1_notation
 */
$spreadsheet_range = 'Sheet1';

$params = array();
if (@trim($_GET['keywords']) != '') {
  $params['keywords'] = $_GET['keywords'];
}
if (@trim($_GET['location']) != '') {
  $params['location'] = $_GET['location'];
}



putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $service_account_file);
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
$service = new Google_Service_Sheets($client);

$result = $service->spreadsheets_values->get($spreadsheet_id, $spreadsheet_range);
$result = $result->getValues();
unset($result[0]);


//require_once "Careerjet_API.php" ;

//$api = new Careerjet_API('en_US') ;
//$page = (isset($_GET['page']) ? $_GET['page'] : 1); # Or from parameters.
//$params['page'] = $page;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Jobs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Export-Table-Data-To-CSV-File-table2csv/src/table2csv.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.2.5/css/tableexport.min.css">  
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
  <script src="https://cdn.rawgit.com/eligrey/FileSaver.js/e9d941381475b5df8b7d7691013401e171014e89/FileSaver.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.2/xlsx.core.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.5/js/tableexport.min.js"></script>

  <script type="text/javascript">
(function(f,b){if(!b.__SV){var e,g,i,h;window.mixpanel=b;b._i=[];b.init=function(e,f,c){function g(a,d){var b=d.split(".");2==b.length&&(a=a[b[0]],d=b[1]);a[d]=function(){a.push([d].concat(Array.prototype.slice.call(arguments,0)))}}var a=b;"undefined"!==typeof c?a=b[c]=[]:c="mixpanel";a.people=a.people||[];a.toString=function(a){var d="mixpanel";"mixpanel"!==c&&(d+="."+c);a||(d+=" (stub)");return d};a.people.toString=function(){return a.toString(1)+".people (stub)"};i="disable time_event track track_pageview track_links track_forms track_with_groups add_group set_group remove_group register register_once alias unregister identify name_tag set_config reset opt_in_tracking opt_out_tracking has_opted_in_tracking has_opted_out_tracking clear_opt_in_out_tracking start_batch_senders people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user people.remove".split(" ");
for(h=0;h<i.length;h++)g(a,i[h]);var j="set set_once union unset remove delete".split(" ");a.get_group=function(){function b(c){d[c]=function(){call2_args=arguments;call2=[c].concat(Array.prototype.slice.call(call2_args,0));a.push([e,call2])}}for(var d={},e=["get_group"].concat(Array.prototype.slice.call(arguments,0)),c=0;c<j.length;c++)b(j[c]);return d};b._i.push([e,f,c])};b.__SV=1.2;e=f.createElement("script");e.type="text/javascript";e.async=!0;e.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?
MIXPANEL_CUSTOM_LIB_URL:"file:"===f.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";g=f.getElementsByTagName("script")[0];g.parentNode.insertBefore(e,g)}})(document,window.mixpanel||[]);

// Enabling the debug mode flag is useful during implementation,
// but it's recommended you remove it for production
mixpanel.init('aef322c34b82f903473aa894cd5b0d00',{debug: true}); 
</script> 

</head>
<style type="text/css">
  #submit {
    margin-top: 22px;
    padding: 12px 30px;
    border-radius: 0px;
    background: #007922;
    border: solid 1px #007922;
    color: white;
  }
  input[type="text"] {
    padding: 20px;
    border-radius: 0px;
  }
  .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    background: #007922;
  }
  .pagination>li>a, .pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {
    color: #007922;
  }
  td a {
    color: #007922;
  }
  .container form {
    margin-top: 100px;
  }
</style>
<body>

<div class="container">
  <!-- <h2>Search Jobs</h2> -->
  <form action="">
   <!--  <div class="col-md-3">
      <div class="form-group">
        <label for="keywords">By keywords:</label>
        <input type="text" value="<?= @$_GET['keywords']; ?>" class="form-control" id="keywords" name="keywords" placeholder="Search by keywords">
      </div>
    </div>
   <div class="col-md-3">
      <div class="form-group">
        <label for="location">By Location:</label>
        <input type="text" value="<?= @$_GET['location']; ?>" class="form-control" id="location" name="location" placeholder="by location">
      </div>
    </div> -->
    <!-- <div class="col-md-3">
      <div class="form-group">
        <label for="company">By company:</label>
        <input type="text" value="<?= @$_GET['company']; ?>" class="form-control" id="company" placeholder="By company" name="by_company">
      </div>
    </div> -->
  <!--   <div class="col-md-3">
      <div class="form-group">
        <button type="submit" id="submit" class="btn btn-default">Search</button>
      </div>
    </div> -->

    <hr>
    <br>
    <!-- <h2>Jobs</h2> -->
    <div class="col-md-12">
      <?php /*if ($result->type == 'JOBS') :
      echo "Found ".$result->hits." jobs" ;
              echo " on ".$result->pages." pages\n" ;
        endif;*/
      ?>
        <table id="tabletodownload" class="table table-bordered">
          <thead>
            <tr>
              <th>Title</th>
              <th>Location</th>
              <th>Company</th>
              <th>Salary</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
          <?php
        
              if (count($result) > 0) {
                foreach( $result as $job ){ 
                  
                 
                  if(isset($salary) && !empty($salary)){
                    $salary = $job['8'];
                  }else{
                    $salary = 0;
                  }
                  ?>
                  <tr>
                  <td><a class="jobBtn" data-title="<?php echo $job['4']; ?>" data-company="<?php echo $job['5']; ?>"  data-salary="<?php echo $salary; ?>" data-posted="<?php echo $job['3']; ?>" target="_blank" href="<?php echo $job['17']; ?>"><?php echo $job['4']; ?></td>
                 <td><?php echo $job['9']; ?></td>
                  <td><?php echo $job['5']; ?></td>
                  <td><?php echo $job['8']; ?></td>
                  <td><?php echo date('m/d/Y', strtotime($job['3'])); ?></td>
                 </tr>               
                <?php }
              }?>
          </tbody>
        </table>
        <?php
        /* # Basic paging code
              if( $page > 1 ){
                echo "Use \$page - 1 to link to previous page\n";
              }
              echo "You are on page $page\n" ;
              if ( $page < $result->pages ){
                echo "Use \$page + 1 to link to next page\n" ;
              }*/
        ?>
        <?php /* ?>
        <ul class="pagination">
          <?php if( $page > 1 ){ 
            echo '<li><a href="?keywords='.@$_GET['keywords'].'&location='.@$_GET['location'].'&company='.@$_GET['company'].'&page='.($page-1).'"><<</a></li>';
          }
          echo '<li class="active"><a  href="#">'.$page.'</a></li>';
          if ( $page < $result->pages ){
            echo '<li><a href="?keywords='.@$_GET['keywords'].'&location='.@$_GET['location'].'&company='.@$_GET['company'].'&page='.($page+1).'">>></a></li>';
          }
          ?>
        </ul>

        <?php */ ?>
    </div>

  </form>
</div>
<script type="text/javascript">





  $(function() {

    $('body').on('click', '.jobBtn', function() {
  mixpanel.track('Table Job Link Clicked',{
    'Title':$(this).attr("data-title"),
    'JobCompany':$(this).attr("data-company"),
    'Salary':$(this).attr("data-salary"),
    'Location':$(this).attr("data-location"),
    'DatePosted':$(this).attr("data-posted"),
    'JobUrl':$(this).attr('href')
    });
  });


    $('#tabletodownload').DataTable();
  /*  $("#tabletodownload").tableExport({
            headings: true,                    // (Boolean), display table headings (th/td elements) in the <thead>
            footers: true,                     // (Boolean), display table footers (th/td elements) in the <tfoot>
            formats: ["xlsx"],    // (String[]), filetypes for the export
            fileName: "id",                    // (id, String), filename for the downloaded file
            bootstrap: true,                   // (Boolean), style buttons using bootstrap
            position: "well" ,                // (top, bottom), position of the caption element relative to table
            ignoreRows: null,                  // (Number, Number[]), row indices to exclude from the exported file
            ignoreCols: null,                 // (Number, Number[]), column indices to exclude from the exported file
            ignoreCSS: ".tableexport-ignore"   // (selector, selector[]), selector(s) to exclude from the exported file
          });*/
  })
</script>
</body>
</html>
