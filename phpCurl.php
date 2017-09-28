<?php
    $username = 'user';
    $password = 'pass';

    $url = "https://url/";
    $cookie = "cookie.txt";  
    $path = "tempcookie";
    
    $ch =curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
    $agent = $_SERVER["HTTP_USER_AGENT"];
    curl_setopt($ch,CURLOPT_USERAGENT, $agent);
    curl_setopt($ch,CURLOPT_TIMEOUT, 200);
    curl_setopt($ch,CURLOPT_COOKIESESSION, true);
    curl_setopt ($ch,CURLOPT_REFERER, $url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch,CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch,CURLOPT_COOKIEFILE, $cookie);  
    $result = curl_exec ($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);//To surpress the Warnings
                $doc->loadHTML($result);
    libxml_use_internal_errors(false);//To surpress the Warnings
    $xp_data_template_data_id = new DOMXpath($doc);
    $nodes_data_input_field_id = $xp_data_template_data_id->query("//input[@name='__csrf_magic']/@value");
    $csrf_tokens = $nodes_data_input_field_id->item(0);
    $csrf_token = $csrf_tokens->value;
    
    $postdata = array("__csrf_magic"=>"$csrf_token",
                  "action"=>"login",
                  "login_username"=>"user",
                  "login_password"=>"pass");
                  
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
    $agent = $_SERVER["HTTP_USER_AGENT"];
    curl_setopt($ch,CURLOPT_USERAGENT, $agent);
    curl_setopt($ch,CURLOPT_TIMEOUT, 200);
    curl_setopt($ch,CURLOPT_COOKIESESSION, true);
    curl_setopt ($ch,CURLOPT_REFERER, $url);
    curl_setopt ($ch,CURLOPT_POST, 1); 
    curl_setopt ($ch,CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch,CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch,CURLOPT_COOKIEFILE, $cookie); 
    $result = curl_exec ($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
    
    $image_id = 28;
    $image_id = $image_id;
    $image_id1 = $image_id.'daily';
    $image_id2 = $image_id.'hourly';
    
    $url1 = 'https://url/graph_image.php?action=view&local_graph_id='.$image_id.'&rra_id=3';
    $url2 = 'https://url/graph_image.php?action=view&local_graph_id='.$image_id.'&rra_id=1'; 
    $url3 = 'https://url/graph_image.php?action=view&local_graph_id='.$image_id.'&rra_id=5';
     
    curl_setopt($ch, CURLOPT_URL, $url1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
  
    
    $image_id1 = $image_id.'daily';
    $image_id2 = $image_id.'hourly';
    $image_id3 = $image_id.'monthly';
   // $path = '/'.$path;
    $fp = fopen($path.'/'.$image_id3.'.jpg','w');
    fwrite($fp, $answer);
    fclose($fp);
    echo 'check file';die();
    
    curl_setopt($ch, CURLOPT_URL, $url2);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $answer2 = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
    
    $fp = fopen($path.'/'.$image_id1.'.jpg','w');
    fwrite($fp, $answer2);
    fclose($fp);
    
    curl_setopt($ch, CURLOPT_URL, $url3);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
    $answer2 = curl_exec($ch);
    if (curl_error($ch)) {
        echo curl_error($ch);
    }
    
    $fp = fopen($path.'/'.$image_id2.'.jpg','w');
    fwrite($fp, $answer2);
    fclose($fp);
    
    $img_path = $path.'/'.$image_id3.'.jpg';
    $img_path2 = $path.'/'.$image_id1.'.jpg';
    $img_path3 = $path.'/'.$image_id2.'.jpg';   
    
    echo '<img class = "img-responsive" src="'.$img_path3.'" />
    <br/>
            <label><span>Hourly (1 Minute Average)</span></label>
    <br/> ';
    echo '<img class = "img-responsive" src="'.$img_path2.'" />
    <br/>
            <label><span>Daily (5 Minute Average)</span></label>
    <br/> ';
    echo '<img class = "img-responsive" src="'.$img_path.'" />
    <br/>
            <label><span>Monthly (2 Hour Average)</span></label>
    <br/> ';
    curl_close($ch);
    ?>