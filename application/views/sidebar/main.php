<?php
?> 
<form method="GET">
  <fieldset>
    <legend>Incident Filter</legend>
    <label>Region</label>
    <select name="cc">
      <option value="">All Regions</option>
      <option value="ET">Etobicoke</option>
      <option value="EY">East York</option>
      <option value="MK">Markham</option>
      <option value="NY">North York</option>
      <option value="TT">Toronto</option>
      <option value="SC">Scarborough</option>
      <option value="YK">York</option>
    </select>

    <label>Incident Type</label>
    <select name="it">
      <option value="">All Types</option>
      <? foreach($incidentTypes['values'] as $incidentType) { ?>
        <option value="<?= $incidentType; ?>"><?= $incidentType; ?></option>
      <? } ?>
    </select>

    <button type="submit" class="btn">Submit</button>
  </fieldset>
</form>
