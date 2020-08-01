<?php
session_start();

$Server = "127.0.0.1";
$database = "xidian2020";
$uid = "root";
$pwd = "root";
$table = "user";
$conInfo = array('Database' => $database, 'UID' => $uid, 'PWD' => $pwd, "CharacterSet" => "UTF-8");
$link = mysqli_connect($Server, $uid, $pwd, $database);
// 选择数据库
//mysqli_select_db($database, $link);
// 编码设置
//mysqli_set_charset('utf8', $link);
@$action = trim($_REQUEST['action']);
if ($action == "login") {

    if ($link) {
        //echo "Connection established.\n";
        @$username = trim($_REQUEST['username']);
        @$userpass = trim($_REQUEST['userpass']);

        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        /*
    if(count($username))
    (
        return;
    )
    */
        $raw_invalid = array('code' => 2, 'msg' => '用户名或密码错误');
        $raw_success = array('code' => 1, 'msg' => '验证成功');
        $raw_fail = array('code' => 0, 'msg' => '验证失败');


        header('Content-Type:application/json'); //这个类型声明非常关键

        if (strlen($username) == 0 || strlen($userpass) == 0) {
            echo json_encode($raw_fail);
            return;
        }
        $sql = "SELECT * FROM $table where user_name=$username";

        //$sql = "SELECT TOP 20 * FROM dbo.post order by post_id desc";

        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(mysqli_error($link), true));
        } else {
            $i = 0;
            $row = mysqli_fetch_array($data, MYSQLI_ASSOC);

            if ($row === NULL) {

                echo json_encode($raw_fail);
            } else {
                $user_pass = $row['user_pass'];
                $user_name = $row['user_name'];

                if (($user_pass == $userpass) && ($user_name == $username)) {
                    echo json_encode($raw_success);
                    $_SESSION['user_pass'] = $user_pass;
                    $_SESSION['user_name'] = $user_name;
                } else {
                    echo json_encode($raw_fail);
                }
                //print_r($row_req);       
            }
        }
    }
}
//end login
else if ($action == "checkLogin") {
    $raw_invalid = array('code' => 2, 'msg' => '用户名或密码错误');
    $raw_success = array('code' => 1, 'msg' => '验证成功');
    $raw_fail = array('code' => 0, 'msg' => '验证失败');

    if (check_login() == 1) {
        echo json_encode($raw_success);
    } else {
        echo json_encode($raw_fail);
    }
}
//end logout
else if ($action == "logout") {
    $_SESSION['user_pass'] = NULL;
    $_SESSION['user_name'] = NULL;

    $raw_invalid = array('code' => 2, 'msg' => '用户名或密码错误');
    $raw_success = array('code' => 1, 'msg' => '验证成功');
    $raw_fail = array('code' => 0, 'msg' => '验证失败');

    if ($_SESSION['user_pass'] == NULL) {
        echo json_encode($raw_success);
    } else {
        echo json_encode($raw_fail);
    }
}

function check_login()
{
    $Server = "127.0.0.1";
    $database = "xidian2020";
    $uid = "root";
    $pwd = "root";
    $table = "user";
    $link = mysqli_connect($Server, $uid, $pwd, $database);

    @$username = trim($_SESSION['user_name']);
    @$userpass = trim($_SESSION['user_pass']);

    if (strlen($username) == 0 || strlen($userpass) == 0) {
        return 0;
    }

    $sql = "SELECT * FROM $table where user_name=$username";

    $data = mysqli_query($link, $sql);

    if ($data === false) {
        die(print_r(mysqli_error($link), true));
    } else {
        $i = 0;
        $row = mysqli_fetch_array($data, MYSQLI_ASSOC);

        if ($row === NULL) {

            return 0;
        } else {
            $user_pass = $row['user_pass'];
            $user_name = $row['user_name'];

            if (($user_pass == $userpass) && ($user_name == $username)) {
                return 1;
            } else {
                return 0;
            }
            //print_r($row_req);       
        }
    }
}
