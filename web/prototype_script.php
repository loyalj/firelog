<?php
    $m = new Mongo();
    $db = $m->fireDepartment;
    $coll = $db->incidents;

    /// Figure out pagination limits
    $perPage =  isset($_GET['pp']) ? intval($_GET['pp']) : 100;
    $currentPage = isset($_GET['p']) ? intval($_GET['p']) : 1;


    $where = array();
    
    
    $cityCode = (isset($_GET['c']) && in_array($_GET['c'], array("NY", "SC", "TT", "EY", "ET", "YK", "MK"))) ? $_GET['c'] : null;
    if($cityCode) {
        $regexObj = new MongoRegex("/, " .$cityCode . "/");
        $where["prime_street"] = $regexObj;
    }

    $alarmLevel = (isset($_GET['al']) && in_array($_GET['al'], array(0, 1, 2, 3, 4, 5))) ? $_GET['al'] : null;
    if($alarmLevel) {
        $where["alarm_level"] = $_GET['al'];
    }

    $area = isset($_GET['ar']) ? $_GET['ar'] : null;
    if($area) {
        $where['area'] = $area;
    }

    $dispatchedUnit = isset($_GET['du']) ? $_GET['du'] : null;
    if($dispatchedUnit) {
        $regexObj = new MongoRegex("/" . $dispatchedUnit . "/");
        $where["dispatched_units"] = $regexObj;
    }
    
    $resultsCount = $coll->find($where)->count();
    $results = $coll->find($where)->skip(($currentPage - 1) * $perPage)->limit($perPage);
    $pages = ceil($resultsCount / $perPage);

    //Some light error correction
    $currentPage = $currentPage <= 0 ? 1 : $currentPage;
    $currentPage = $currentPage > $pages ? $pages : $currentPage;    
?>

<p>There are <?= $resultsCount; ?> incidents in the records.</p>
<table>
    <tr>
        <? for($i = 1; $i <= $pages; $i++) { ?>
            <td>
                <? if($i == $currentPage) { echo "<strong>"; } ?>
                <a href="/fire/?p=<?= $i;?>"><?= $i; ?></a></td>
                <? if($i == $currentPage) { echo "</strong>"; } ?> 
        <? } ?>
    </tr>
</table>    
<table>
    <tr>
        <td>Prime Street</td>
        <td>Cross Street</td>
        <td>Dispatch Time</td>
        <td>Incident Number</td>
        <td>Incident Type</td>
        <td>Alarm Level</td>
        <td>Area</td>
        <td>Dispatched Units</td>
    </tr>
    <? foreach($results as $result) { ?>
        <tr>
            <td><?= $result['prime_street'] ?></td>
            <td><?= $result['cross_street'] ?></td>
            <td><?= $result['dispatch_time'] ?></td>
            <td><?= $result['incident_id'] ?></td>
            <td><?= $result['incident_type'] ?></td>
            <td><?= $result['alarm_level'] ?></td>
            <td><?= $result['area'] ?></td>
            <td><?= $result['dispatched_units'] ?></td>
        </tr>
    <? } ?>
</table>
<table>
    <tr>
        <? for($i = 1; $i <= $pages; $i++) { ?>
            <td>
                <? if($i == $currentPage) { echo "<strong>"; } ?>
                <a href="/fire/?p=<?= $i;?>"><?= $i; ?></a></td>
                <? if($i == $currentPage) { echo "</strong>"; } ?> 
        <? } ?>
    </tr>
</table>    
