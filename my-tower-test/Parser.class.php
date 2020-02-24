<?php
 require_once('RowView.class.php');
class Parser
{
    
    public function parse($file_name)
    {
   
    $file_name = "files/". $file_name;
    $array = $this->get_row_view($file_name);
    $array = $this->filter_arrays($array);
    // $stat_array = $this->get_counted_stats($array);
    return $array;
   
    }

    private function get_row_view($file_name){
    //array to hold arrays

     $main_array = [];

    //opening the file for reading

    if (($parser = fopen("{$file_name}", "r")) !== FALSE) 
    {
      while (($data = fgetcsv($parser, 1000, ",")) !== FALSE) 
      {
          $row = new RowView();
          $row->id = $data[0];
          $row->date = $data[1];
          $row->call_duration = $data[2];
          $row->phone_number = $data[3];
          $row->ip = $data[4];
          

        // Push individual arrays into main array
        $main_array[] = $row;
     	
      }
      
   

    }
    fclose($parser);
   
    return $main_array;
    }
    private function filter_arrays($main_array){
      $unique_ids = [];
      $unique_objects = [];
      $object_stats =[];
      $index = 0;
      foreach($main_array as $row_object){
        $continent = $this->get_continent_from_ip($row_object->ip);

        $index++;
        // if($index == 20)
        // {
        //   die("<pre>" .print_r(array( $call, $continent, $row_object, $unique_objects[$row_object->id]['calls']),true) ."</pre>");

        // }

       if(in_array($row_object->id, $unique_ids)){
        foreach($unique_objects[$row_object->id]['calls'] as $index => &$call){
          
          if($call['continent'] == $continent){

           $call['call_duration'] = intval($row_object->call_duration) + intval($call['call_duration']);
           $call['num_calls'] = intval($call['num_calls']) + 1;
           $object_stats[$row_object->id] =
           [
             "id" => $row_object->id,
               "total_calls" => $call['num_calls'],
               'total_time' => $call['call_duration'],
           ];
          }
          else{
            $unique_objects[$row_object->id]['calls'][] = $this->make_call_array($row_object);
            if($unique_objects[$row_object->id] == $call['id']){
            
            }

          }
          
        }
        

      }
      
      else{
        $unique_ids[] = $row_object->id;
        $call_array = $this->make_call_array($row_object);
      
        $unique_objects[$row_object->id] = 
        [
            "id" => $row_object->id,
            "calls" => [$call_array]
          

        ];
      
      }
      // if($unique_objects[$row_object->id]['calls'][] = $this->make_call_array($row_object)){
      //     foreach(array($this->make_call_array($row_object)) as $counter){
      //       if(isset($unique_objects[$row_object->id]['calls'])){
      //         foreach(array($unique_objects[$row_object->id]['calls']) as $stat_total){
      //         $total_calls_in_seconds = intval($stat_total['call_duration']) + intval($row_object->call_duration);
      //         $total_calls_in_quantity = count(array($stat_total['continent']), COUNT_RECURSIVE  );
      //         $continent[] = $stat_total['continent'];
      //         $object_stats[$row_object->id] = 
      //         [
      //            "total_geo_seconds {$stat_total['continent']}" => $total_calls_in_seconds,
      //            "total_geo_calls {$stat_total['continent']}" => $total_calls_in_quantity,
      //         ];
      //       }
          
      //   }
        
      //     }
      // };
  
}
  // die("<pre>" .print_r(array( $unique_objects, $object_stats),true) ."</pre>");


//return $unique_objects;
//return $unique_ids;
return $object_stats;
}


private function get_continent_from_ip($ip){
  $analyzer = new Analyzer();
  $continent = $analyzer->get_continent($ip);
  return $continent;
}

private function make_call_array($row_object)
{
  $continent = $this->get_continent_from_ip($row_object->ip);
  return   [
    "id" => $row_object->id,
    "date" => $row_object->date,
    "call_duration" => $row_object->call_duration,
    "phone_number" => $row_object->phone_number,
    "continent" => $continent,
    "num_calls" => 0
  ];
}
 

}






