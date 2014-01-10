<html>
<head>
<title>PlayStation&reg;4 Status</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="icon" href=/ps4/favicon.ico sizes="32x32" type=image/vnd.microsoft.icon>
<script src="jquery-2.0.3.min.js"></script>
</head>
<body>
<div id="page">
<div id="header">
<div id="ps4_name"></div>
</div>
<div id="content">
<div id="ps4_status"></div>
<div id="ps4_updated"></div>
<hr>
<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody id="ps4_activity">
    </tbody>
</table>
<hr>
<div id="info">Updated every 1 minute.</div>
<div id="source">Source Code: <a href="http://github.com/dsokoloski/ps4-wake">github.com/dsokoloski/ps4-wake</a></div>
<div id="copyright">&copy;2014 Darryl Sokoloski &lt;<a href="mailto:darryl@sokoloski.ca">darryl@sokoloski.ca</a>&gt;</div>
</div>
</div>
<script>
$(document).ready(function() {
    var interval = 1000 * 10;
    var refresh = function() {
        $.ajax({
            url: '/ps4/update.php',
            cache: false,
            dataType: 'json',
            success: function(data) {
                var row_class = 'row_odd';
                $('#ps4_name').html(data.name);
                $('#ps4_status').html(data.status);
                $('#ps4_updated').html(data.timestamp);
                $('#ps4_activity > tr').remove();
                $(data.activity).each(function(i, val) {
                    var row = '<tr class="' + row_class + '">';
                    row_class = (row_class == 'row_odd') ? 'row_even' : 'row_odd';
                    $.each(val, function(k, v) {
                        //console.log(k + ' : ' + v);
                        if (k == 'status')
                            row = row + '<td class="activity">' + v + '</td>';
                        else if (k == 'timestamp')
                            row = row + '<td class="timestamp">' + v + '</td>';
                    });
                    row = row + '</tr>';
                    $('#ps4_activity').append(row);
                });
                setTimeout(function() { refresh(); }, interval);
            }
        });
    };
    refresh();
});
</script>
</body>
</html>
<?php
// vi: expandtab shiftwidth=4 softtabstop=4 tabstop=4
