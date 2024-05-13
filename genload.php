<?php
  # Check to see if the user requested load to be generated (GET genload=1) or
  # if the genload session variable has not been set
  if (isset($_REQUEST['genload']) && $_REQUEST['genload'] == 1) {
    # Requesting load generation
    # Get ELB URL and validate that it is a valid URL
    $ELB = "http://" . $_REQUEST['elb'] . "/";
    if (!preg_match('|^http://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $ELB)) {
      echo $ELB . " is not a valid URL!";
      exit;
    }

    # Validate that wave requests & connections are valid numbers
    $n1 = "-n " . intval($_REQUEST['n1']) . " ";
    $c1 = "-c " . intval($_REQUEST['c1']) . " ";
    $n2 = "-n " . intval($_REQUEST['n2']) . " ";
    $c2 = "-c " . intval($_REQUEST['c2']) . " ";
    $n3 = "-n " . intval($_REQUEST['n3']) . " ";
    $c3 = "-c " . intval($_REQUEST['c3']) . " ";
    
    # Zero 
    $w1 = "echo '' > /tmp/genload.txt; ";
    $w1 = $w1 . "ab -w " . $n1 . $c1 . $ELB . " >> /tmp/genload.txt 2>&1; ";
    $w2 = "ab -w " . $n2 . $c2 . $ELB . " >> /tmp/genload.txt 2>&1; ";
    $w3 = "ab -w " . $n3 . $c3 . $ELB . " >> /tmp/genload.txt 2>&1; ";
    $w3 = $w3 . "echo '\nBenchmark Complete!!' >> /tmp/genload.txt; ";

    # This will generate apache bench load in 3 waves based on the values provided in the form
    echo exec('('  . $w1 . $w2 . $w3 . ') &>> /tmp/genload.txt &');
    echo "Starting benchmark tests! (auto refresh in 2 seconds)<br/>";
    echo "<meta http-equiv=\"refresh\" content=\"2,URL=/genload.php?genload=2#end\" />";
    exit; 
  }

  if (isset($_REQUEST['genload']) && $_REQUEST['genload'] == 2) {
    # Code here for displaying results of /tmp/genload.txt
    echo "<b>Displaying results from Apache Bench (auto refresh every 5 seconds)</b><p>\n";
    echo "<meta http-equiv=\"refresh\" content=\"5,URL=/genload.php?genload=2#end\" />\n";
    passthru('cat /tmp/genload.txt');
    echo "<a name=\"end\">\n";
    echo "&nbsp; ";
   exit;
  }
  
?>
