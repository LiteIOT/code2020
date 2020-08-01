<?php
$Server = "127.0.0.1";
$database = "xidian2020";
$uid = "root";
$pwd = "root";
$table = "catalog";
$conInfo = array('Database' => $database, 'UID' => $uid, 'PWD' => $pwd, "CharacterSet" => "UTF-8");
$link = mysqli_connect($Server, $uid, $pwd, $database);
// 选择数据库
//mysqli_select_db($database, $link);
// 编码设置
//mysqli_set_charset('utf8', $link);
$action = trim($_REQUEST['action']); //接收前端传来的数据 


if ($action == "login") {
    if ($link) {
        //echo "Connection established.\n";
        //@$page_num = trim($_REQUEST['page_num']);

        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        $sql = "SELECT * FROM $table where cat_id>1 order by cat_id desc";

        //$sql = "SELECT TOP 20 * FROM dbo.post order by post_id desc";

        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header('Content-Type:application/json'); //这个类型声明非常关键
            $results = array();
            $i = 0;
            while ($row = mysqli_fetch_array($data)) {


                $cat_id = $row['cat_id'];

                $sql_don = "SELECT sum(don_quantity) FROM donation where cat_id = $cat_id";
                $data_don = mysqli_query($link, $sql_don);
                $row_don = mysqli_fetch_array($data_don);
                // print_r($sql_req);
                //print_r($row_req);
                $cat_sum_don = $row_don[0];


                $sql_req = "update catalog set cat_remain =$cat_sum_don where cat_id = $cat_id";
                $data_req = mysqli_query($link, $sql_req);
                $row_req = mysqli_fetch_array($data_req);
                // print_r($sql_req);
                //print_r($row_req);

            }

            if ($results) {
                //echo json_encode($results);
            }
        }
    }
} else if ($action == "getMostReqirement") {

    if ($link) {
        //echo "Connection established.\n";
        //@$page_num = trim($_REQUEST['page_num']);

        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        $sql = "SELECT sum(req_remain) as req_sum, product_name FROM product, requirement where product.product_id = requirement.product_id GROUP BY requirement.product_id order by req_sum desc limit 0, 5";

        //$sql = "SELECT TOP 20 * FROM dbo.post order by post_id desc";

        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header('Content-Type:application/json'); //这个类型声明非常关键
            $results = array();
            $i = 0;
            while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
              
                $results[] = $row;
                $i++;
            }

            if ($results) {
                echo json_encode($results);
            }
        }
    }
}
