<?php require_once('Connections/wallboard.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_wallboard, $wallboard);
$query_inbound_drop_detail = "SELECT vicidial_closer_log.campaign_id as 'INBOUND GROUP', vicidial_closer_log.call_date AS 'DATE', vicidial_closer_log.length_in_sec AS 'TIME BEFORE DROP', vicidial_closer_log.phone_number AS 'PHONE NUMBER' FROM `vicidial_closer_log` WHERE `call_date` > CURDATE() AND  `status` = 'DROP'";
$inbound_drop_detail = mysql_query($query_inbound_drop_detail, $wallboard) or die(mysql_error());
$row_inbound_drop_detail = mysql_fetch_assoc($inbound_drop_detail);
$totalRows_inbound_drop_detail = mysql_num_rows($inbound_drop_detail);mysql_select_db($database_wallboard, $wallboard);
$query_inbound_drop_detail = "SELECT vicidial_closer_log.campaign_id as 'INBOUND GROUP', vicidial_closer_log.call_date AS 'DATE', vicidial_closer_log.length_in_sec AS 'TIME BEFORE DROP', vicidial_closer_log.phone_number AS 'PHONE NUMBER' FROM `vicidial_closer_log` WHERE `call_date` > CURDATE() AND  `status` = 'DROP'";
$inbound_drop_detail = mysql_query($query_inbound_drop_detail, $wallboard) or die(mysql_error());
$row_inbound_drop_detail = mysql_fetch_assoc($inbound_drop_detail);
$totalRows_inbound_drop_detail = mysql_num_rows($inbound_drop_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_outbound_drop_detail = "SELECT vicidial_log.campaign_id as 'CAMPAIGN', vicidial_log.phone_number AS 'PHONE NUMBER', vicidial_log.call_date AS 'DATE' FROM `vicidial_log` WHERE `call_date` > CURDATE() AND `status` = 'DROP'";
$outbound_drop_detail = mysql_query($query_outbound_drop_detail, $wallboard) or die(mysql_error());
$row_outbound_drop_detail = mysql_fetch_assoc($outbound_drop_detail);
$totalRows_outbound_drop_detail = mysql_num_rows($outbound_drop_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_outbound_answered_detail = "SELECT vicidial_log.call_date, vicidial_log.length_in_sec, vicidial_log.phone_number, vicidial_log.`user` AS agent, vicidial_users.full_name, vicidial_campaigns.campaign_name FROM vicidial_log INNER JOIN vicidial_users ON vicidial_log.`user` = vicidial_users.`user` INNER JOIN vicidial_campaigns ON vicidial_log.campaign_id = vicidial_campaigns.campaign_id WHERE vicidial_log.call_date > CURDATE() AND vicidial_log.`user` <> 'VDAD'";
$outbound_answered_detail = mysql_query($query_outbound_answered_detail, $wallboard) or die(mysql_error());
$row_outbound_answered_detail = mysql_fetch_assoc($outbound_answered_detail);
$totalRows_outbound_answered_detail = mysql_num_rows($outbound_answered_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_outbound_calls_detail = "SELECT vicidial_log.call_date, vicidial_log.length_in_sec, vicidial_log.phone_number, vicidial_campaigns.campaign_name, vicidial_users.full_name FROM vicidial_log INNER JOIN vicidial_campaigns ON vicidial_log.campaign_id = vicidial_campaigns.campaign_id INNER JOIN vicidial_users ON vicidial_log.`user` = vicidial_users.`user` WHERE vicidial_log.call_date > CURDATE()";
$outbound_calls_detail = mysql_query($query_outbound_calls_detail, $wallboard) or die(mysql_error());
$row_outbound_calls_detail = mysql_fetch_assoc($outbound_calls_detail);
$totalRows_outbound_calls_detail = mysql_num_rows($outbound_calls_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_inbound_answered_details = "SELECT vicidial_closer_log.length_in_sec, vicidial_closer_log.phone_number, vicidial_users.full_name, vicidial_inbound_groups.group_name, vicidial_closer_log.call_date FROM vicidial_closer_log INNER JOIN vicidial_users ON vicidial_closer_log.`user` = vicidial_users.`user` INNER JOIN vicidial_inbound_groups ON vicidial_closer_log.campaign_id = vicidial_inbound_groups.group_id WHERE vicidial_closer_log.call_date > CURDATE() AND vicidial_users.`user` <> 'VDCL'";
$inbound_answered_details = mysql_query($query_inbound_answered_details, $wallboard) or die(mysql_error());
$row_inbound_answered_details = mysql_fetch_assoc($inbound_answered_details);
$totalRows_inbound_answered_details = mysql_num_rows($inbound_answered_details);

mysql_select_db($database_wallboard, $wallboard);
$query_inbound_calls_detail = "SELECT call_log.caller_code AS `Caller ID`, call_log.start_time AS Date, call_log.length_in_min AS `Call Lenght`, vicidial_inbound_dids.did_description AS `Inbound Group` FROM call_log INNER JOIN vicidial_inbound_dids ON call_log.number_dialed = vicidial_inbound_dids.did_pattern WHERE `channel_group` = 'DID_INBOUND' AND `start_time` > CURDATE()";
$inbound_calls_detail = mysql_query($query_inbound_calls_detail, $wallboard) or die(mysql_error());
$row_inbound_calls_detail = mysql_fetch_assoc($inbound_calls_detail);
$totalRows_inbound_calls_detail = mysql_num_rows($inbound_calls_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_pause_agents_detail = "SELECT vicidial_users.full_name, vicidial_live_agents.last_call_finish, vicidial_live_agents.calls_today, vicidial_campaigns.campaign_name FROM vicidial_live_agents INNER JOIN vicidial_users ON vicidial_users.`user` = vicidial_live_agents.`user` INNER JOIN vicidial_campaigns ON vicidial_live_agents.campaign_id = vicidial_campaigns.campaign_id WHERE vicidial_live_agents.`status` = 'PAUSED'";
$pause_agents_detail = mysql_query($query_pause_agents_detail, $wallboard) or die(mysql_error());
$row_pause_agents_detail = mysql_fetch_assoc($pause_agents_detail);
$totalRows_pause_agents_detail = mysql_num_rows($pause_agents_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_agents_available_detail = "SELECT vicidial_users.full_name, vicidial_campaigns.campaign_name, vicidial_live_agents.last_call_finish, vicidial_live_agents.calls_today FROM vicidial_live_agents INNER JOIN vicidial_users ON vicidial_live_agents.`user` = vicidial_users.`user` INNER JOIN vicidial_campaigns ON vicidial_live_agents.campaign_id = vicidial_campaigns.campaign_id WHERE vicidial_live_agents.`status` = 'READY'";
$agents_available_detail = mysql_query($query_agents_available_detail, $wallboard) or die(mysql_error());
$row_agents_available_detail = mysql_fetch_assoc($agents_available_detail);
$totalRows_agents_available_detail = mysql_num_rows($agents_available_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_live_agents_detail = "SELECT vicidial_live_agents.last_call_time, vicidial_live_agents.calls_today, vicidial_users.full_name, vicidial_campaigns.campaign_name FROM vicidial_live_agents INNER JOIN vicidial_users ON vicidial_live_agents.`user` = vicidial_users.`user` INNER JOIN vicidial_campaigns ON vicidial_live_agents.campaign_id = vicidial_campaigns.campaign_id WHERE vicidial_live_agents.`status` = 'INCALL'";
$live_agents_detail = mysql_query($query_live_agents_detail, $wallboard) or die(mysql_error());
$row_live_agents_detail = mysql_fetch_assoc($live_agents_detail);
$totalRows_live_agents_detail = mysql_num_rows($live_agents_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_calls_ringing_detail = "SELECT vicidial_campaigns.campaign_name, vicidial_auto_calls.phone_number, vicidial_auto_calls.call_time FROM vicidial_auto_calls INNER JOIN vicidial_campaigns ON vicidial_auto_calls.campaign_id = vicidial_campaigns.campaign_id WHERE vicidial_auto_calls.stage = 'START'";
$calls_ringing_detail = mysql_query($query_calls_ringing_detail, $wallboard) or die(mysql_error());
$row_calls_ringing_detail = mysql_fetch_assoc($calls_ringing_detail);
$totalRows_calls_ringing_detail = mysql_num_rows($calls_ringing_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_waiting_call_detail = "SELECT vicidial_auto_calls.phone_number, vicidial_auto_calls.call_time, vicidial_inbound_groups.group_name, vicidial_auto_calls.queue_position FROM vicidial_auto_calls INNER JOIN vicidial_inbound_groups ON vicidial_inbound_groups.group_id = vicidial_auto_calls.campaign_id WHERE vicidial_auto_calls.`status` = 'LIVE' ORDER BY vicidial_auto_calls.queue_position ASC";
$waiting_call_detail = mysql_query($query_waiting_call_detail, $wallboard) or die(mysql_error());
$row_waiting_call_detail = mysql_fetch_assoc($waiting_call_detail);
$totalRows_waiting_call_detail = mysql_num_rows($waiting_call_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_ivr_calls_detail = "SELECT vicidial_auto_calls.phone_number, vicidial_auto_calls.queue_position, call_log.number_dialed, call_log.start_time, vicidial_inbound_dids.did_description FROM vicidial_auto_calls RIGHT OUTER JOIN call_log ON vicidial_auto_calls.callerid = call_log.caller_code INNER JOIN vicidial_inbound_dids ON vicidial_inbound_dids.did_pattern = call_log.number_dialed WHERE vicidial_auto_calls.`status` = 'IVR' AND call_log.end_time IS NULL";
$ivr_calls_detail = mysql_query($query_ivr_calls_detail, $wallboard) or die(mysql_error());
$row_ivr_calls_detail = mysql_fetch_assoc($ivr_calls_detail);
$totalRows_ivr_calls_detail = mysql_num_rows($ivr_calls_detail);

mysql_select_db($database_wallboard, $wallboard);
$query_live_call_detail = "SELECT vicidial_campaigns.campaign_name, vicidial_auto_calls.callerid, vicidial_auto_calls.call_time, vicidial_auto_calls.call_type, call_log.extension, vicidial_inbound_dids.did_description FROM vicidial_auto_calls LEFT JOIN vicidial_campaigns ON vicidial_auto_calls.campaign_id = vicidial_campaigns.campaign_id LEFT JOIN call_log ON vicidial_auto_calls.callerid = call_log.caller_code INNER JOIN vicidial_inbound_dids ON call_log.extension = vicidial_inbound_dids.did_pattern WHERE call_log.end_time IS NULL ORDER BY vicidial_auto_calls.auto_call_id DESC";
$live_call_detail = mysql_query($query_live_call_detail, $wallboard) or die(mysql_error());
$row_live_call_detail = mysql_fetch_assoc($live_call_detail);
$totalRows_live_call_detail = mysql_num_rows($live_call_detail);
?>
<style>
.clear{
	clear:both;
}
.detail div{
	height: 14px !important;
	text-align:left !important;
    border: none !important;
    color: #000 !important;
    font-weight: normal !important;
    padding-top: 0 !important;
    text-shadow: none !important;
}

.modal-content {
    /* position: absolute; */
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 10px;
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
    box-shadow: 0 3px 9px rgba(0,0,0,.5);
    width: 700px;
    margin: auto;
}

.modal-dialog {
    width: 700px !important;
    margin: 30px auto;
}

.answered_calls{
	width: 800px !important;
}


.close {
    float: right;
    font-size: 28px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
    margin-right: 5px;
    margin-top: 5px;
}
.alert{
	margin-bottom: 0px !important;
}
</style>


<!-- ### CALLS DETAIL ###-->


<!-- ### Active Calls ###-->
<div id="live_calls" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span><h3>Active Calls</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_live_call_detail > 0) {?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Inbound Group / Campaign</th>
                        <th>DID</th>
                        <th>Caller ID</th>
                        <th>Call Type</th>
                        <th>Call Time</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; if ($totalRows_live_call_detail > 0) { do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_live_call_detail['campaign_name']." ".$row_live_call_detail['did_description']; ?></td>
                        <td><?php echo "(".substr($row_live_call_detail['extension'],1,3).") ".substr($row_live_call_detail['extension'],4,3)."-".substr($row_live_call_detail['extension'],7,10); ?></td>
                        <td><?php echo "(".substr($row_live_call_detail['callerid'],1,3).") ".substr($row_live_call_detail['callerid'],4,3)."-".substr($row_live_call_detail['callerid'],7,10); ?></td>
                        <td><?php echo $row_live_call_detail['call_type']; ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_live_call_detail['call_time'])); ?></td>
                    </tr>
                <?php } while ($row_live_call_detail = mysql_fetch_assoc($live_call_detail));} ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no active calls </h1>
            <?php } ?>
      </div>
    </div>

  </div>
</div>
<!-- ### Active Calls ###-->

<!-- ### Calls on IVR ###-->
<div id="ivr_calls" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-info" role="alert"><span class="glyphicon glyphicon-th" aria-hidden="true"></span><h3>Calls in IVR</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_ivr_calls_detail > 0) {?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Inbound DID</th>
                        <th>DID Decription</th>
                        <th>Caller ID</th>
                        <th>Queue Position</th>
                        <th>Call Time</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo "(".substr($row_ivr_calls_detail['number_dialed'],1,3).") ".substr($row_ivr_calls_detail['number_dialed'],4,3)."-".substr($row_ivr_calls_detail['number_dialed'],7,10); ?></td>
                        <td><?php echo $row_ivr_calls_detail['did_description']; ?></td>
                        <td><?php echo $row_ivr_calls_detail['phone_number']; ?></td>
                        <td><?php echo $row_ivr_calls_detail['queue_position']; ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_ivr_calls_detail['start_time'])); ?></td>
                    </tr>
                <?php } while ($row_ivr_calls_detail = mysql_fetch_assoc($ivr_calls_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no calls in IVR</h1>
            <?php } ?>
      </div>
    </div>

  </div>
</div>
<!-- ### Calls on IVR ###-->

<!-- ### Calls Waiting ###-->
<div id="waiting_calls" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-time" aria-hidden="true"></span><h3>Waiting Calls</h3></div>
        <div class="panel panel-default">
        	<?php if ($totalRows_waiting_call_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Inbound Group / Campaign</th>
                        <th>Phone Number</th>
                        <th>Queue Position</th>
                        <th>Call Time</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_waiting_call_detail['group_name']; ?></td>
                        <td><?php echo $row_waiting_call_detail['phone_number']; ?></td>
                        <td><?php echo $row_waiting_call_detail['queue_position']; ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_waiting_call_detail['call_time'])); ?></td>
                    </tr>
                <?php } while ($row_waiting_call_detail = mysql_fetch_assoc($waiting_call_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no waiting calls </h1>
            <?php } ?>
      </div>
    </div>

  </div>
</div>
<!-- ### Calls Waiting ###-->

<!-- ### Calls Ringing ###-->
<div id="calls_ringing" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span><h3>Calls Ringing</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_calls_ringing_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Campaign</th>
                        <th>Phone Number</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_calls_ringing_detail['campaign_name']; ?></td>
                        <td><?php echo $row_calls_ringing_detail['phone_number']; ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_calls_ringing_detail['call_time'])); ?></td>
                    </tr>
                <?php } while ($row_calls_ringing_detail = mysql_fetch_assoc($calls_ringing_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no call ringing </h1>
            <?php } ?>
      </div>
    </div>

  </div>
</div>
<!-- ### Calls Ringing ###-->


<!-- ### AGENTS DETAIL ###-->


<!-- ### Live Agents ###-->
<div id="agents_oncall" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-headphones" aria-hidden="true"></span><h3>Agents on Call</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_live_agents_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Agent Name</th>
                        <th>Campaign</th>
                        <th>Last Call</th>
                        <th>Calls Today</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo ucwords(strtolower($row_live_agents_detail['full_name'])); ?></td>
                        <td><?php echo $row_live_agents_detail['campaign_name']; ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_live_agents_detail['last_call_time'])); ?></td>
                        <td><?php echo $row_live_agents_detail['calls_today']; ?></td>
                    </tr>
                <?php } while ($row_live_agents_detail = mysql_fetch_assoc($live_agents_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no agent on calls </h1>
            <?php } ?>
      </div>
    </div>

  </div>
</div>
<!-- ### Live Agents ###-->

<!-- ### Agents Available ###-->
<div id="agents_available" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-time" aria-hidden="true"></span><h3>Agents Available</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_agents_available_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Agent Name</th>
                        <th>Campaign</th>
                        <th>Last Call</th>
                        <th>Calls Today</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo ucwords(strtolower($row_agents_available_detail['full_name'])); ?></td>
                        <td><?php echo $row_agents_available_detail['campaign_name']; ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_agents_available_detail['last_call_finish'])); ?></td>
                        <td><?php echo $row_agents_available_detail['calls_today']; ?></td>
                    </tr>
                <?php } while ($row_agents_available_detail = mysql_fetch_assoc($agents_available_detail )); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no agent available </h1>
            <?php } ?>
      </div>
    </div>

  </div>
</div>
<!-- ### Agents Available ###-->

<!-- ### Agents on Pause ###-->
<div id="agents_onpause" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-pause" aria-hidden="true"></span><h3>Agents on Pause or Disposition</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_pause_agents_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Agent Name</th>
                        <th>Campaign</th>
                        <th>Last Call</th>
                        <th>Calls Today</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo ucwords(strtolower($row_pause_agents_detail['full_name'])); ?></td>
                        <td><?php echo $row_pause_agents_detail['campaign_name']; ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_pause_agents_detail['last_call_finish'])); ?></td>
                        <td><?php echo $row_pause_agents_detail['calls_today']; ?></td>
                    </tr>
                <?php } while ($row_pause_agents_detail = mysql_fetch_assoc($pause_agents_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no agent on pause </h1>
            <?php } ?>
      </div>
    </div>

  </div>
</div>
<!-- ### Agents on Pause ###-->


<!-- ### INBOUND CALLS DETAIL ###-->


<!-- Inbound Total Calls -->
<div id="total_inbound" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span><h3>Inbound Total Calls</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_inbound_calls_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Inbound Group</th>
                        <th>Caller ID</th>
                        <th>Call Lenght</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_inbound_calls_detail['Inbound Group']; ?></td>
                        <td><?php echo "(".substr($row_inbound_calls_detail['Caller ID'],1,3).") ".substr($row_inbound_calls_detail['Caller ID'],4,3)."-".substr($row_inbound_calls_detail['Caller ID'],7,10); ?></td>
                        <td><?php echo round($row_inbound_calls_detail['Call Lenght']/60); ?> minutes</td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_inbound_calls_detail['Date'])); ?></td>
                    </tr>
                <?php } while ($row_inbound_calls_detail = mysql_fetch_assoc($inbound_calls_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no records for inbound calls </h1>
            <?php } ?>
        </div>
    </div>
    

  </div>
</div>
<!-- Inbound Total Calls -->

<!-- Inbound Answered Calls -->
<div id="inbound_answered" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-star" aria-hidden="true"></span><h3>Inbound Answered Calls</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_inbound_answered_details > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Inbound Group</th>
                        <th>Agent</th>
                        <th>Phone Number</th>
                        <th>Call Lenght</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_inbound_answered_details['group_name']; ?></td>
                        <td><?php echo ucwords(strtolower($row_inbound_answered_details['full_name'])); ?></td>
                        <td><?php echo "(".substr($row_inbound_answered_details['phone_number'],0,3).") ".substr($row_inbound_answered_details['phone_number'],3,3)."-".substr($row_inbound_answered_details['phone_number'],6,10); ?></td>
                        <td><?php echo round($row_inbound_answered_details['length_in_sec']/60); ?> minutes</td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_inbound_answered_details['call_date'])); ?></td>
                    </tr>
                <?php } while ($row_inbound_answered_details = mysql_fetch_assoc($inbound_answered_details)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no inbound answered calls </h1>
            <?php } ?>
        </div>
    </div>

  </div>
</div>
<!-- Inbound Answered Calls -->

<!-- Inbound Drop Calls -->
<div id="inbound_drops" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><h3>Inbound Drops Calls</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_inbound_drop_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Inbound Group</th>
                        <th>Phone Number</th>
                        <th>Call Time</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_inbound_drop_detail['INBOUND GROUP']; ?></td>
                        <td><?php echo "(".substr($row_inbound_drop_detail['PHONE NUMBER'],0,3).") ".substr($row_inbound_drop_detail['PHONE NUMBER'],3,3)."-".substr($row_inbound_drop_detail['PHONE NUMBER'],6,10); ?></td>
                        <td><?php echo $row_inbound_drop_detail['TIME BEFORE DROP']; ?> seconds</td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_inbound_drop_detail['DATE'])); ?></td>
                    </tr>
                <?php } while ($row_inbound_drop_detail = mysql_fetch_assoc($inbound_drop_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no inbound drop calls </h1>
            <?php } ?>
        </div>
    </div>

  </div>
</div>
<!-- Inbound Drop Calls -->


<!-- ### OUTBOUND CALLS DETAIL ###-->

<!-- Outbound Total Calls -->
<div id="total_outbound" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span><h3>Outbound Calls</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_outbound_calls_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Campaign</th>
                        <th>Agent</th>
                        <th>Phone Number</th>
                        <th>Call Lenght</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_outbound_calls_detail['campaign_name']; ?></td>
                        <td><?php echo ucwords(strtolower($row_outbound_calls_detail['full_name'])); ?></td>
                        <td><?php echo "(".substr($row_outbound_calls_detail['phone_number'],0,3).") ".substr($row_outbound_calls_detail['phone_number'],3,3)."-".substr($row_outbound_calls_detail['phone_number'],6,10); ?></td>
                        <td><?php echo round($row_outbound_calls_detail['length_in_sec']/60); ?> minutes</td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_outbound_calls_detail['call_date'])); ?></td>
                    </tr>
                <?php } while ($row_outbound_calls_detail = mysql_fetch_assoc($outbound_calls_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no records for outbound calls </h1>
            <?php } ?>
        </div>
    </div>

  </div>
</div>
<!-- Outbound Total Calls -->

<!-- Outbound Answered Calls -->
<div id="outbound_answered" class="modal fade" role="dialog">
  <div class="modal-dialog answered_calls">

    <div class="modal-content answered_calls">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-star" aria-hidden="true"></span><h3>Outbound Answered Calls</h3></div>
        <div class="panel panel-default">
        	<?php if ($totalRows_outbound_answered_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Campaign</th>
                        <th>Agent</th>
                        <th>Phone Number</th>
                        <th>Call Lenght</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_outbound_answered_detail['campaign_name']; ?></td>
                        <td><?php echo ucwords(strtolower($row_outbound_answered_detail['full_name'])); ?></td>
                        <td><?php echo "(".substr($row_outbound_answered_detail['phone_number'],0,3).") ".substr($row_outbound_answered_detail['phone_number'],3,3)."-".substr($row_outbound_answered_detail['phone_number'],6,10); ?></td>
                        <td><?php echo round($row_outbound_answered_detail['length_in_sec']/60); ?> minutes</td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_outbound_answered_detail['call_date'])); ?></td>
                    </tr>
                <?php } while ($row_outbound_answered_detail = mysql_fetch_assoc($outbound_answered_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no outbound answered call</h1>
            <?php } ?>
        </div>
    </div>

  </div>
</div>
<!-- Outbound Answered Calls -->

<!-- Outbound Drop Calls -->
<div id="outbound_drops" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
    	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><h3>Outbound Drops Calls</h3></div>
        <div class="panel panel-default">
            <?php if ($totalRows_outbound_drop_detail > 0) { ?>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>#</th>
                        <th>Campaign</th>
                        <th>Phone Number</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; do { $i = $i + 1;?>
                	<tr>
                    	<th scope="row"><?php echo $i?></th>
                        <td><?php echo $row_outbound_drop_detail['CAMPAIGN']; ?></td>
                        <td><?php echo "(".substr($row_outbound_drop_detail['PHONE NUMBER'],0,3).") ".substr($row_outbound_drop_detail['PHONE NUMBER'],3,3)."-".substr($row_outbound_drop_detail['PHONE NUMBER'],6,10); ?></td>
                        <td><?php echo date("n/j/Y g:i a", strtotime($row_outbound_drop_detail['DATE'])); ?></td>
                    </tr>
                <?php } while ($row_outbound_drop_detail = mysql_fetch_assoc($outbound_drop_detail)); ?>
                </tbody>
            </table>
            <?php } else { ?>
            	<h1 style="text-align:center; padding: 25px;"> There is no outbound drop call </h1>
            <?php } ?>
        </div>
    </div>

  </div>
</div>
<!-- Outbound Drop Calls -->

<!-- ### OUTBOUND CALLS DETAIL ###-->
<?php
mysql_free_result($inbound_drop_detail);

mysql_free_result($outbound_drop_detail);

mysql_free_result($outbound_answered_detail);

mysql_free_result($outbound_calls_detail);

mysql_free_result($inbound_answered_details);

mysql_free_result($inbound_calls_detail);

mysql_free_result($pause_agents_detail);

mysql_free_result($agents_available_detail);

mysql_free_result($live_agents_detail);

mysql_free_result($calls_ringing_detail);

mysql_free_result($waiting_call_detail);

mysql_free_result($ivr_calls_detail);

mysql_free_result($live_call_detail);
?>
