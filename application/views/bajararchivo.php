<?php
    header('Content-Type: application/download');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header("Content-Length: " . filesize(base_url()."adjuntos/".$id_pedio."/".$filename));

    $fp = fopen(base_url()."adjuntos/".$id_pedio."/".$filename, "r");
    fpassthru($fp);
    fclose($fp);
?>