<?php
    $connection = ssh2_connect('10.149.137.246', 22);
    //var_dump($connection);
    ssh2_auth_password($connection, 'cachac6', 'ca..chac6');
    $stream = ssh2_exec($connection, 'cd /brm/pin;ls');
    $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
    stream_set_blocking($errorStream, true);
    stream_set_blocking($stream, true);
    $errorStreamContent = stream_get_contents($errorStream);
    $streamContent = stream_get_contents($stream);
    $output = $errorStreamContent . "\n" . $streamContent;
    $lastLine = substr($streamContent, -41, 40);
    echo 'exec-';
    echo $output;
    echo 'exec-';
    echo $lastLine;
?>