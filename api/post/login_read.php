<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/LoginPost.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new LoginPost($db);

  // Blog post query
  $result = $post->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $posts_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
	'UID'       => $UID,	
	'PASSWORD' => $PASSWORD,
	'FNAME'	   => $FNAME,
	'LNAME'	   => $LNAME,
	'DOB'	   => $DOB,
	'GENDER'   => $GENDER,
	'CLASS'	   => $CLASS,
	'ROLE'	   => $ROLE,
	'ISACTIVE' => $ISACTIVE,
	'MOBILE'   => $MOBILE);

      // Push to "data"
      array_push($posts_arr, $post_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
