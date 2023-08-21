<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ioa";
$chat_list = [];
$messages = [];
$arr_uid = [];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['action']) and !empty($_POST['action'])){


  if($_POST['action'] == 'chat_list'){
    // Get New Messages
    $sql = "SELECT send_id, COUNT(send_id) as msg_count,id,name,profile_image, mobile, message, seen FROM messages WHERE send_id != 'admin' AND seen = 0 GROUP BY send_id ORDER BY id DESC";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
        array_push($chat_list,$row);
        array_push($arr_uid,$row['send_id']);
      }
    }

    if(mysqli_num_rows($result) < 10){
      // Get old Messages
      $sql = "SELECT send_id, COUNT(send_id) as msg_count, id, name,profile_image, mobile, message,seen FROM messages WHERE send_id != 'admin' AND seen = 1 GROUP BY send_id ORDER BY id DESC LIMIT 300";
      $result = $conn->query($sql);
      if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {
          if(in_array($row['send_id'], $arr_uid) == false){
            array_push($chat_list,$row);
          }
        }
        $chat_list = array_reverse($chat_list);
      }      
    }

    if(!empty($_POST['active_uid'])){
      $active_uid = $_POST['active_uid'];
      $last_id = 0;
      if(!empty($_POST['last_id'])){
        $last_id = $_POST['last_id'];
      }
      $sql = "SELECT * FROM messages WHERE (send_id = $active_uid OR recevied_id = $active_uid) AND id > $last_id ORDER BY id DESC LIMIT 200";
      $result = $conn->query($sql);
      if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)) {
          array_push($messages,$row);
        }
        $messages = array_reverse($messages);
      }
      

      $update_sql = "UPDATE messages SET seen = true WHERE send_id = $active_uid OR recevied_id = $active_uid";
      $result = $conn->query($update_sql);
    }    

  }


  if($_POST['action'] == 'messages'){
// Get Active User Message
    if(!empty($_POST['active_uid'])){
      $active_uid = $_POST['active_uid'];
      $sql = "SELECT * FROM messages WHERE (send_id = $active_uid OR recevied_id = $active_uid) ORDER BY id DESC LIMIT 80;";
      $result = $conn->query($sql);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          array_push($messages,$row);
        }
      }
      
      $update_sql = "UPDATE messages SET seen = true WHERE send_id = $active_uid OR recevied_id = $active_uid";
      $result = $conn->query($update_sql);

    }
  }

}
echo json_encode(['chat_list'=>$chat_list,'messages'=>$messages]);


?>