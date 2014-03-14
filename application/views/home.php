<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid" style="height:480px;">
          <div id="mapCanvas" class="span12"></div>
        </div>

<div class="row-fluid">
    <div class="span12">
        <?= $incidentsTable; ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span6 offset3 text-centered">
        <p>Found <?= $selectedIncidents; ?> matches in <?= $totalIncidents;?> total incidents on record.</p>
    </div>
</div>
<div class="pagination pagination-small pagination-centered">
    <ul>
        <?= $paginationHTML; ?>
    </ul>
</div>
