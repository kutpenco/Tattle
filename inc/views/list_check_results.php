<?php
$tmpl->set('title', 'Self Service Alerts based on Graphite metrics');
$tmpl->set('graphlot',true);
$tmpl->place('header');

 try {
        $check = new Check($check_id);
	$affected = fMessaging::retrieve('affected', fURL::get());
  } catch (fEmptySetException $e) {
?>
        <p class="info">There are currently no Tattle checks. <a href="<?=Check::makeURL('add'); ?>">Add one now</a></p>
        <?php
  } ?>
<fieldset>
        <span>Name : <?=$check->prepareName(); ?></span> | 
        <span>Target : <?=$check->prepareTarget(); ?></span>
        <div class="graphite">
                <div id="canvas" style="padding:1px">
                    <div id="graphcontainer" style="float:left;">
                        <div id="graph" style="width:600px;height:300px"></div>
                        <div id="overview" style="width:600px;height:66px"></div>
                    </div>
                     <p style="clear:left">&nbsp</p>

                      <div class="metricrow" style="display:none">
                         <span id="target" class="metricName"><?=$check->prepareTarget(); ?></span>.
                         <span id="error_threshold"><?=$check->prepareError(); ?></span>
                         <span id="warn_threshold"><?=$check->prepareWarn(); ?></span>
                         <span id="check_id"><?=$check->prepareCheckId(); ?></span> 
                      </div>

            </div>

        </div>
<!--<span><?=Check::showGraph($check); ?></span>
          <span><?=Check::showGraph($check,true,'-24Hours',320,true); ?></span> -->
    </fieldset>
<?php
  try {
    $check_results->tossIfEmpty();
    $affectd = fMessaging::retrieve('affected',fURL::get());
   ?>
        <a class="btn small primary" href="<?=CheckResult::makeURL('ackAll', $check = new Check($check_id)); ?>">Clear All</a>
	<table class="zebra-striped">
    <tr>
    <th>Status</th>
    <th>Value</th>
    <th>Error</th>
    <th>Warn</th>
    <th>State</th>
    <th>Time</th>
       </tr>    
	<?php
	$first = TRUE;
	foreach ($check_results as $check_result) {
        $check = new Check($check_result->getCheck_Id());
	?>
    	<tr>
        <td><?=$status_array[$check_result->prepareStatus()]; ?></td>
        <td><?=$check_result->prepareValue(); ?></td>
        <td><?=$check->prepareError(); ?></td>
        <td><?=$check->prepareWarn(); ?></td>
        <td><?=$check_result->prepareState(); ?></td>
        <td><?=$check_result->prepareTimestamp('Y-m-d H:i:s'); ?></td>
        </tr>
    <?php } ?>
    </table></div>
    <?
} catch (fEmptySetException $e) {
	?>
	<p class="info">There are currently no alerts for this checks.</p>
	<?php
}
?>
<?php $tmpl->place('footer') ?>
