<?php

include_once('include.php');

date_default_timezone_set('America/New_York');

header('Content-Type: application/json');

$data = array(
    'name' => 'PS4 Wake',
    'state' => 0,
    'status' => 'Unknown',
    'timestamp' => get_long_time(time()),
    'activity' => array()
);

$history = get_history();
if (count($history)) {
    $last_status = null;
    $data['name'] = $history[0]->host_name;
    $data['timestamp'] = get_long_time($history[0]->timestamp);
    get_status($history[0], $data['state'], $data['status']);
    for ($i = 1; count($history) > 1 && $i < count($history); $i++) {
        $entry = array('state' => 0, 'status' => 'Unknown', 'timestamp' => 'Unknown');
        if (!get_status($history[$i], $entry['state'], $entry['status'], true))
            continue;
        if ($entry['status'] == $last_status) continue;
        $last_status = $entry['status'];
        get_diff_time($history[$i], $entry['timestamp']);
        $data['activity'][] = $entry;
    }
}

echo json_encode($data);

// vi: expandtab shiftwidth=4 softtabstop=4 tabstop=4
