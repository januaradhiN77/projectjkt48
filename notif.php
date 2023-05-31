<?php
if (isset($_POST['kirim'])) {
    $app =$_POST['pesan'];
    $isi =$_POST['isi'];
    $url =$_POST['url'];
    $response = sendMessage($app, $isi, $url);
    $return["allresponses"] = $response;
    $return = json_encode($return);

    $data = json_decode($response, true);
    print_r($data);
    $id = $data['id'];
    print_r($id);

    print("\n\nJSON received:\n");
    print($return);
    print("\n");
}
function sendMessage($app, $isi, $url) {
    $content      = array(
        "en" => $isi
    );
    $heading = array(
        "en" => 'Mengidol48'
    );
    $fields = array(
        'app_id' => $app,
        'included_segments' => array(
            'Subscribed Users'
        ),
        'data' => array(
            "foo" => "bar"
        ),
        'contents' => $content,
        'headings' => $heading,
        'url'=> $url,
    );
    
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NTcxMDk5ZDYtMmRlNC00Yjg1LTgzYjItNjRmMmNhZTNhYmE4
'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}


?>