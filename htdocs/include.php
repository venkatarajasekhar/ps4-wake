<?php

define('PS4WAKE_LOG', '/tmp/ps4-wake.log');

function get_history()
{
    $history = array();
    if (!file_exists(PS4WAKE_LOG)) return $history;

    $fh = fopen(PS4WAKE_LOG, 'r');
    if (! is_resource($fh)) return $history;

    while (!feof($fh)) {
        $entry = trim(fgets($fh, 4096));
        if (!strlen($entry)) continue;
        $history[] = json_decode($entry);
    }
    fclose($fh);

    return $history;
}

function get_long_time($timestamp)
{
    $long_time = strftime('%B %e', $timestamp);
    $day = strftime('%e', $timestamp);
    if ($day > 3 && $day <= 20)
        $long_time .= 'th';
    else switch (substr($day, -1)) {
    case '1':
        $long_time .= 'st';
        break;
    case '2':
        $long_time .= 'nd';
        break;
    case '3':
        $long_time .= 'rd';
        break;
    default:
        $long_time .= 'th';
        break;
    }
    $long_time .= ', ' . trim(strftime('%l:', $timestamp));
    $long_time .= strftime('%M%P', $timestamp);
    return $long_time;
}

function get_status($entry, &$state, &$status, $filter = false)
{
    switch ($entry->code) {
    case 620:
        if ($filter) return false;
        $state = 1;
        $status = 'Standby';
        break;
    case 200:
        $state = 2;
        if ($entry->running_app_name == NULL) {
            if ($filter) return false;
            $status = 'Home Screen';
        }
        else
            $status = $entry->running_app_name;
        break;
    }

    return true;
}

function get_diff_time($entry, &$timestamp)
{
    $now = new DateTime();
    $since = $now->diff(new DateTime(strftime('%F %T', $entry->timestamp)));

    if ($since->d > 0) $timestamp = sprintf("%d day%s ago",
        $since->d, ($since->d > 1) ? 's' : '');
    else if ($since->h > 0) $timestamp = sprintf("%d hour%s ago",
        $since->h, ($since->h > 1) ? 's' : '');
    else if ($since->i > 0) $timestamp = sprintf("%d minute%s ago",
        $since->i, ($since->i > 1) ? 's' : '');
    else $timestamp = sprintf("%d second%s ago",
        $since->s, ($since->s > 1) ? 's' : '');
}

// vi: expandtab shiftwidth=4 softtabstop=4 tabstop=4
