<?php
    //connection to mongodb
    //dbname= ride ------ collection -admin -booking -users -cars
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $query = new MongoDB\Driver\Query([]); 
    $bulkWrite = new MongoDB\Driver\BulkWrite();
    // $row=$mng->executeQuery('riderent.collection_name',$query);

?>