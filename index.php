<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Elastic Load Balancing</title>
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />

</head>
<body>
 
<div id="content-outer">
<!-- start content -->
<center>
<div id="content">
        <table border="0" width="50%" cellpadding="0" cellspacing="0" id="content-table">
        <tr>
                <th rowspan="3" class="sized"><img src="./images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
                <th class="topleft"></th>
                <td id="tbl-border-top">&nbsp;</td>
                <th class="topright"></th>
                <th rowspan="3" class="sized"><img src="./images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
        </tr>
        <tr>
                <td id="tbl-border-left"></td>
                <td>
                <!--  start content-table-inner ...................................................................... START -->
                <div id="content-table-inner">

                        <!--  start table-content  -->
                        <div id="table-content">

<?php
  # Get the instance ID from meta-data and store it in the $instance_id variable
  $tokenUrl = "http://169.254.169.254/latest/api/token";
  // トークンを取得するリクエスト
$tokenTtlSeconds = 21600;
$tokenOptions = [
    "http" => [
        "method" => "PUT",
        "header" => [
            "X-aws-ec2-metadata-token-ttl-seconds: " . $tokenTtlSeconds
        ]
    ]
];
$tokenContext = stream_context_create($tokenOptions);
$token = file_get_contents($tokenUrl, false, $tokenContext);

// インスタンスIDを取得するリクエスト
$instanceIdUrl = "http://169.254.169.254/latest/meta-data/instance-id";
$instanceIdOptions = [
    "http" => [
        "method" => "GET",
        "header" => [
            "X-aws-ec2-metadata-token: " . $token
        ]
    ]
];
$instanceIdContext = stream_context_create($instanceIdOptions);
$instance_id = file_get_contents($instanceIdUrl, false, $instanceIdContext);
  # Get the instance's availability zone from metadata and store it in the $zone variable
  $zoneUrl = "http://169.254.169.254/latest/meta-data/placement/availability-zone";
  // アベイラビリティーゾーンを取得するリクエスト
$zoneOptions = [
    "http" => [
        "method" => "GET",
        "header" => [
            "X-aws-ec2-metadata-token: " . $token
        ]
    ]
];
$zoneContext = stream_context_create($zoneOptions);
$zone = file_get_contents($zoneUrl, false, $zoneContext);

  # Print the Availability Zone

?>
                        <center>
                                <br/>
                                <br/>
                                <h2>EC2 Instance ID: <?php echo $instance_id; ?></h2>
                                <h2>Zone: <?php echo  $zone; ?></h2>
                        </center>
                        </div>
                        <!--  end table-content  -->

                        <div class="clear"></div>
                 
                </div>
                <!--  end content-table-inner ............................................END  -->
                </td>
                <td id="tbl-border-right"></td>
        </tr>
        <tr>
                <th class="sized bottomleft"></th>
                <td id="tbl-border-bottom">&nbsp;</td>
                <th class="sized bottomright"></th>
        </tr>
        </table>
        <div class="clear">&nbsp;</div>

</div>
</center>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

<div class="clear">&nbsp;</div>
 
</body>
</html>