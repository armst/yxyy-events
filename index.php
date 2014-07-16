<?php 

  if ($_GET['id']) {
    $event_id = $_GET['id'];

    $json = file_get_contents('http://strongarmed.com/yxyy/events/getevents.php');
    $events = json_decode($json, TRUE);
    $donkeypunch = array();
    
    if (!empty($events)) {
      foreach($events as $event) {
        if ($event['id'] == $event_id) {
          $donkeypunch = $event;
          $dt = explode(' ', $event['when']);
          $donkeypunch['time'] = $dt[1];
          $donkeypunch['time'] = substr($donkeypunch['time'] , 0, -3);
        }
      }
    }
    
  }
?>

<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Submit Your Event</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    <link rel="stylesheet" href="css/custom.css">
<script>
function submitForm() {
	
      fdata = $('#formguy').serializeArray();
			//console.log(fdata);
			
           $.ajax({
            url: "addevent.php",
            data: fdata,
            type: 'POST',
            success: function (resp) {
              var json = $.parseJSON(resp);
              //console.log(resp);
              $("#feedbackDialog").show();
              $("#text").text(json.message);
            },
            error: function(resp) {
              var json = $.parseJSON(resp);
              console.log(resp);
              $("#feedbackDialog").show();
              $("#text").text(json.message);
            }  
        });
		
}
</script>
  </head>
  <body>
    <div data-role="page" id="addevent">
      <div data-role="header" id="header" class="add">
        <div data-role="navbar">
          <ul>
            <li><a href="index.php" data-icon="plus" <?php if (empty($event_id)) { ?> class="ui-btn-active" <?php } ?>>Add New</a></li>
            <li><a href="locations.html" data-icon="location">Locations</a></li>
            <li><a href="list.html" data-icon="edit" rel="external" <?php if (!empty($event_id)) { ?> class="ui-btn-active" <?php } ?>>Edit</a></li>
          </ul>
        </div>
      </div>
  
      <div role="main" class="ui-content">

        <div id="feedbackDialog" style="display:none;" onclick="this.style.display='none'"><a class="gotit ui-icon-delete ui-btn-icon-notext"></a><p id="text"></p></div>
        <!--<div id="feedbackDialog" data-role="popup" data-dismissible="false"><p id="text"></p><a data-rel="back" class="ui-btn-right"></a></div>-->

        <form action="#" method="post" data-ajax="false" enctype="multipart/form-data" id='formguy'>
          <?php if (!empty($event_id)) { ?>
            <input type='hidden' name='id' value='<?php echo $event_id;?>'>
          <?php } ?>
          <div class="column one">
            <label for="title">Title <span class="required">required</span></label>
            <input type="text" name="title" id="title" value="<?=$donkeypunch['title'];?>" maxlength="52">

            <label for="description">Description <span class="required">required</span></label>
            <textarea name="description" id="description"><?=$donkeypunch['description'];?></textarea>

            <label for="location">Location <span class="optional">optional</span></label>
            <input type="text" name="location" id="location" value="<?=$donkeypunch['location'];?>" maxlength="20">
          </div>
          <div class="column two">
            <label for="date" class="select">Day <span class="required">required</span></label>
            <select name="date" id="date">
              <option value="2014-07-11" <?php if (strpos($donkeypunch['when'], '07-11') !== false) { echo 'selected'; } ?>>Friday</option>
              <option value="2014-07-12" <?php if (strpos($donkeypunch['when'], '07-12') !== false) { echo 'selected'; } ?>>Saturday</option>
              <option value="2014-07-13" <?php if (strpos($donkeypunch['when'], '07-13') !== false) { echo 'selected'; } ?>>Sunday</option>
              <option value="2014-07-14" <?php if (strpos($donkeypunch['when'], '07-14') !== false) { echo 'selected'; } ?>>Monday</option>
            </select>

            <label for="time">Time <span class="required">required</span></label>
            <input type="time" data-clear-btn="true" name="time" id="time" value="<?=$donkeypunch['time'];?>">

            <!--<div class="uploader">
              <label for="image">Upload Image <span class="optional">optional</span></label>
              <input type="file" name="image" id="image" accept="image/*" capture>
            </div>-->
            <div class="required" style="float:none">Please tap once and be patient!</div>
            <input class ='submityourass' type="button" onClick='javascript:submitForm();' value="<?php if (empty($event_id)) { ?>Post This Event!<?php } else { ?>Update Event<?php } ?>" />

          </div>

        </form>

      </div>
    </div>



    <script type="text/javascript">
    $( "a.gotit" ).click(function( event ) {
      event.preventDefault();
      $( "#feedbackDialog" ).hide();
    });
    </script>

  </body>
</html>