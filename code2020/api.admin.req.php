<?php
$Server = "127.0.0.1";
$database = "xidian2020";
$uid = "root";
$pwd = "root";
$table = "requirement";
$conInfo = array('Database' => $database, 'UID' => $uid, 'PWD' => $pwd, "CharacterSet" => "UTF-8");
$link = mysqli_connect($Server, $uid, $pwd, $database);
// 选择数据库
//mysqli_select_db($database, $link);
// 编码设置
//mysqli_set_charset('utf8', $link);


$result = 0;
$row_per_page = 10;

$action = trim($_REQUEST['action']); //接收前端传来的数据 


if ($action == "login") {
    $result = 0;
    $username = trim($_REQUEST['username']); //接收前端传来的数据 
    $password = trim($_REQUEST['password']); //接收前端传来的数据 


    if ($link) {
        //echo "Connection established.\n";
        $sql = "SELECT * FROM dbo.admin_user where user_name=" . $username;
        //echo $sql;
        $data = mysql_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {

            if ($userinfo = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {

                if (trim($userinfo['user_pass']) == $password) {

                    $result = 1;
                } else {
                    /*
          echo  strcmp($userinfo['userPass'] , $password);
          echo gettype($password);
          echo gettype($userinfo['userPass']);
          echo $username.$password .$userinfo['userPass'];
          */
                }
            }
        }
    } else {
        print_r(sqlsrv_errors(), true);
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "code: " . $error['code'] . "<br />";
                echo "message: " . $error['message'] . "<br />";
            }
        }
        die("");
    }


    /*验证验证码是否正确*/
    session_start();



    $raw_success = array('code' => 1, 'msg' => '验证码正确');

    $raw_fail = array('code' => 0, 'msg' => '验证码错误');

    $res_success = json_encode($raw_success);
    $res_fail = json_encode($raw_fail);


    header('Content-Type:application/json'); //这个类型声明非常关键

    if ($result) {

        echo $res_success;
    } else {
        echo $res_fail;
    }
} else if ($action == "addPost") {
    $result = 0;
    @$req_material = trim($_REQUEST['material']); //接收前端传来的数据 
    @$req_quantity = trim($_REQUEST['quantity']); //接收前端传来的数据 
    @$req_recipient =trim($_REQUEST['recipient']);  //接收前端传来的数据 
    @$req_contact = trim($_REQUEST['contact']); //接收前端传来的数据 
    @$req_time = time(); //插入时间
    @$req_telephone = trim($_REQUEST['telephone']); //接收前端传来的数据 
    @$req_address = trim($_REQUEST['address']); //插入时间
    @$req_datetime = date("Y-m-d");

    if ($link) {
        //echo "Connection established.\n";
        $sql = "INSERT INTO $table (req_material, req_quantity, req_recipient, req_address, req_datetime) VALUES ('$req_material', '$req_quantity', '$req_recipient','$req_address', '$req_datetime')";
        //$sql = "INSERT INTO dbo.userinfo (userName, userPass) VALUES ('$title', '$description')";
        $data = mysqli_query($link, $sql);

        if ($data === false) {
            print "error";
        } else {
            $result = 1;
        }
    } else {
        print_r(sqlsrv_errors(), true);
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "code: " . $error['code'] . "<br />";
                echo "message: " . $error['message'] . "<br />";
            }
        }
        die("");
    }


    /*验证验证码是否正确*/
    session_start();



    $raw_success = array('code' => 1, 'msg' => '验证码正确');

    $raw_fail = array('code' => 0, 'msg' => '验证码错误');

    $res_success = json_encode($raw_success);
    $res_fail = json_encode($raw_fail);


    header('Content-Type:application/json'); //这个类型声明非常关键

    if ($result) {

        echo $res_success;
    } else {
        echo $res_fail;
    }
}
//end addTest

// getTracking
else if ($action == "getTracking") {

    $result = 0;

    if ($link) {
        //echo "Connection established.\n";
        @$req_id = trim($_REQUEST['req_id']);

        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        $sql = "SELECT * FROM disclosure, product, donation where disclosure.req_id = $req_id and disclosure.product_id = product.product_id and disclosure.don_id = donation.don_id order by dis_id desc";

        //$sql = "SELECT TOP 20 * FROM dbo.post order by post_id desc";

        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header('Content-Type:application/json'); //这个类型声明非常关键
            $results = array();
            $i = 0;
            while ($row = mysqli_fetch_array($data)) {
                $results[] = $row;
                //$i++;
            }

            if ($results) {
                echo json_encode($results);
            }
        }
    }
}

else if ($action == "switchRows") {
    $num_rows = 0;
    if ($link) {

        @$index_1 = $_REQUEST['index_1'];
        @$moveMode = $_REQUEST['moveMode'];
        @$index_2 = "";

        $sql = "";
        //--当前
        //SELECT TOP 1 * FROM dbo.tbl_SoleHome_Menu WHERE MenuID=2

        if ($moveMode > 0) {
            //上移一条
            //--下一条
            $sql =  "SELECT TOP 1 * FROM dbo.post WHERE post_time>$index_1 ORDER BY post_time ASC";
        } else {
            //下移一条  
            //上一条
            $sql = "SELECT TOP 1 * FROM dbo.post WHERE post_time<$index_1 ORDER BY post_time DESC";
        }


        //echo "Connection established.\n";
        $data = mysql_query($link, $sql);
        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            $row = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC);
            @$index_2 = $row['post_time'];

            $sql = "UPDATE dbo.post SET post_time = CASE WHEN post_time = $index_1 THEN $index_2       
                WHEN post_time = $index_2       
                THEN $index_1      
                ELSE post_time END       
                WHERE post_time IN ( $index_1,  $index_2)";
            $data = mysql_query($link, $sql);

            if ($data === false) {
                die(print_r(sqlsrv_errors(), true));
            } else {
                header('Content-Type:application/json'); //这个类型声明非常关键
                $raw_success = array('code' => 1, 'count' => $num_rows);
                $res_success = json_encode($raw_success);
                echo $res_success;
            }
        }
    }
} else if ($action == "listPost") {

    $result = 0;

    if ($link) {
        //echo "Connection established.\n";
        //@$page_num = trim($_REQUEST['page_num']);

        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        $sql = "SELECT requirement.*, product.*, sum(disclosure.dis_quantity) as sum_quantity FROM  
        (requirement left join product on requirement.product_id = product.product_id) 
        left join disclosure on requirement.req_id = disclosure.req_id 
        group by requirement.req_id order by requirement.req_id desc";;

        //$sql = "SELECT TOP 20 * FROM dbo.post order by post_id desc";

        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header('Content-Type:application/json'); //这个类型声明非常关键
            $results = array();
            $i = 0;
            while ($row = mysqli_fetch_array($data)) {
                $results[] = $row;
                //$i++;
            }

            if ($results) {
                echo json_encode($results);
            }
        }
    }
}
//end listPost

else if ($action == "getPost") {

    @$note_id = $_REQUEST['note_id'];

    $result = 0;
    if ($link) {
        //echo "Connection established.\n";
        //@$page_num = trim($_REQUEST['page_num']);

        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        if($note_id < 1)
        {
            $sql = "SELECT * FROM $table order by note_id desc limit 0, 1";
        }
        else
        {
            $sql = "SELECT * FROM $table where note_id = $note_id";
        }
        

        //

        
        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header('Content-Type:application/json'); //这个类型声明非常关键
            $results = '';
            $i = 0;
            while ($row = mysqli_fetch_array($data)) {
                $results = $row;
                break;
            }

            if ($results) {
                echo json_encode($results);
            }
        }
    }
}

// countPost
else if ($action == "countPost") {

    $num_rows = 0;

    if ($link) {
        //echo "Connection established.\n";

        $sql = "SELECT COUNT(*) FROM dbo.post";

        $data = mysql_query($link, $sql);

        list($num_rows) = sqlsrv_fetch_array($data);


        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header('Content-Type:application/json'); //这个类型声明非常关键

            $raw_success = array('code' => 1, 'count' => $num_rows);

            $res_success = json_encode($raw_success);

            if ($num_rows) {
                echo $res_success;
            }
        }
    }
}



//Del Post
else if ($action == "delPost") {
    $result = 0;
    $note_id = trim($_REQUEST['note_id']);
    if ($link) {
        //echo "Connection established.\n";
        $sql = "Delete FROM $table where note_id=$note_id";
        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            $result = 1;
        }
    } else {
        print_r(sqlsrv_errors(), true);
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "code: " . $error['code'] . "<br />";
                echo "message: " . $error['message'] . "<br />";
            }
        }
        die("");
    }


    /*验证验证码是否正确*/
    session_start();



    $raw_success = array('code' => 1, 'msg' => '验证码正确');

    $raw_fail = array('code' => 0, 'msg' => '验证码错误');

    $res_success = json_encode($raw_success);
    $res_fail = json_encode($raw_fail);


    header('Content-Type:application/json'); //这个类型声明非常关键

    if ($result) {

        echo $res_success;
    } else {
        echo $res_fail;
    }
}
//delPost

//updatePost
else if ($action == "updatePost") {
    $result = 0;
    $note_id = trim($_REQUEST['note_id']);
    if ($link) {
        //echo "Connection established.\n";
        $note_date = trim($_REQUEST['note_date']); //接收前端传来的数据 
        $note_title = trim($_REQUEST['note_title']); //接收前端传来的数据 
        $note_author = trim($_REQUEST['note_author']); //接收前端传来的数据 
        $note_content = mysqli_real_escape_string($link, trim($_REQUEST['note_content']));  //接收前端传来的数据 

        $sql = "UPDATE $table SET note_date = '$note_date', note_title = '$note_title', note_author = '$note_author', note_content = '$note_content' where note_id=$note_id";
        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            $result = 1;
        }
    } else {
        print_r(sqlsrv_errors(), true);
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                echo "code: " . $error['code'] . "<br />";
                echo "message: " . $error['message'] . "<br />";
            }
        }
        die("");
    }


    /*验证验证码是否正确*/
    session_start();



    $raw_success = array('code' => 1, 'msg' => '验证码正确');

    $raw_fail = array('code' => 0, 'msg' => '验证码错误');

    $res_success = json_encode($raw_success);
    $res_fail = json_encode($raw_fail);


    header('Content-Type:application/json'); //这个类型声明非常关键

    if ($result) {

        echo $res_success;
    } else {
        echo $res_fail;
    }
}
        //updatePost
