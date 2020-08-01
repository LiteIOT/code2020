<?php
$Server = "127.0.0.1";
$database = "xidian2020";
$uid = "root";
$pwd = "root";
$table = "transfer";
$conInfo = array('Database' => $database, 'UID' => $uid, 'PWD' => $pwd, "CharacterSet" => "UTF-8");
$link = mysqli_connect($Server, $uid, $pwd, $database);
// 选择数据库
//mysqli_select_db($database, $link);
// 编码设置
//mysqli_set_charset('utf8', $link);

$result = 0;
$row_per_page = 10;

$action = trim($_REQUEST['action']); //接收前端传来的数据 

if ($action == "listPost") {

    $result = 0;

    if ($link) {
        //echo "Connection established.\n";
        //@$page_num = trim($_REQUEST['page_num']);

        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        $sql = "SELECT * FROM $table, product, requirement where product.product_id =transfer.product_id and requirement.req_id =transfer.req_id order by tran_id desc";

        //$sql = "SELECT TOP 20 * FROM dbo.post order by post_id desc";

        $data = mysqli_query($link, $sql);

        if ($data === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            header('Content-Type:application/json'); //这个类型声明非常关键
            $results = array();
            $i = 0;
            while ($row = mysqli_fetch_array($data)) {


                $product_id = $row['product_id'];
                $sql_req = "SELECT sum(req_quantity) FROM requirement where product_id = $product_id";
                $data_req = mysqli_query($link, $sql_req);
                $row_req = mysqli_fetch_array($data_req);
                // print_r($sql_req);
                //print_r($row_req);
                $row['cat_sum_req'] = $row_req[0];

                /*
                $sql_don = "SELECT sum(don_quantity) FROM donation where cat_id = $cat_id";
                $data_don = mysqli_query($link, $sql_don);
                $row_don = mysqli_fetch_array($data_don);
                // print_r($sql_req);
                //print_r($row_req);
                $row['cat_sum_don'] = $row_don[0];
                */

                $results[] = $row;
                $i++;
            }

            if ($results) {
                echo json_encode($results);
            }
        }
    }
}
//end onSearch
else if ($action == "onSearch") {

    $result = 0;

    if ($link) {
        //echo "Connection established.\n";
        @$search_value = trim($_REQUEST['search_value']);

        $search_value = '%' . $search_value . '%';
        // $page_num = $page_num * $row_per_page;
        //$sql = "SELECT TOP 10 * FROM dbo.question where post_id = $post_id order by question_id desc";
        $sql = "SELECT * FROM $table, product, requirement where catalog.product_id =transfer.product_id and requirement.req_id =transfer.req_id and product.product_title like '$search_value' order by tran_id desc";
        //echo $sql;
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
                $sql_req = "SELECT sum(req_quantity) FROM requirement where cat_id = $cat_id";
                $data_req = mysqli_query($link, $sql_req);
                $row_req = mysqli_fetch_array($data_req);
                // print_r($sql_req);
                //print_r($row_req);
                $row['cat_sum_req'] = $row_req[0];

                /*
                $sql_don = "SELECT sum(don_quantity) FROM donation where cat_id = $cat_id";
                $data_don = mysqli_query($link, $sql_don);
                $row_don = mysqli_fetch_array($data_don);
                // print_r($sql_req);
                //print_r($row_req);
                $row['cat_sum_don'] = $row_don[0];
                */

                $results[] = $row;
                $i++;
            }

            if ($results) {
                echo json_encode($results);
            }
        }
    }
}
//end onSearch