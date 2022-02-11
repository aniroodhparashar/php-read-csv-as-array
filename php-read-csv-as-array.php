function CsvFile(){
    $file='../path-to-your-csv-file/filename.csv';
    
    // open the file
    $handle = @fopen($file, "r");

    if (!$handle) {
        throw new \Exception("Couldn't open $file!");
    }
    $result = array();
    $filesize = filesize($file);
   
    // read the first line
    $first = strtolower(fgets($handle,1970));

    // get the keys

    $keys = str_getcsv($first);

    $keys = array_map('trim', $keys);

    $get_keys_only=0;
    if ($get_keys_only === 1) {
        return array("keys" => $keys, "rowcount" => count(file($file, FILE_SKIP_EMPTY_LINES)));
    }
    // read until the end of file

    while (($buffer = fgetcsv($handle,$filesize)) !== false) {
        // read the next entry
       
        $array=$buffer;
        if (empty($array))
            continue;

        // all values are empty
        if (!array_filter($array)) {
            continue;
        }

        $row = array();
        $i = 0;

        // replace numeric indexes with keys for each entry
      
        foreach ($keys as $key) {

            $key = trim($key);

            $row[$key] = $array[$i];
            $i++;
        }

        // add relational array to final result
        $result[] = $row;

    }

    fclose($handle);
   echo "<pre>";print_r($result);die;
