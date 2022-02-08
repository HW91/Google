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
    <div class="col-md-3">
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
    </div>
    <!-- <div class="col-md-3">
      <div class="form-group">
        <label for="company">By company:</label>
        <input type="text" value="<?= @$_GET['company']; ?>" class="form-control" id="company" placeholder="By company" name="by_company">
      </div>
    </div> -->
    <div class="col-md-3">
      <div class="form-group">
        <button type="submit" id="submit" class="btn btn-default">Search</button>
      </div>
    </div>

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
                  echo '<tr>';
                  echo '<td><a target="_blank" href="'.$job['17'].'">'.$job['4'].'</td>' ;
                  echo '<td>'.$job['9'].'</td>';
                  echo '<td>'.$job['5'].'</td>';
                  echo '<td>'.$job['8'].'</td>';
                  echo '<td>'.date('m/d/Y H:i:s', strtotime($job['3'])).'</td>';
                  echo '</tr>';               
                }
              }
              
             
           
  ?>
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
