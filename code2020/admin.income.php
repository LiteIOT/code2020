<?php
include "common.check.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>物资管理</title>
    <!-- Bootstrap core CSS-->
    <link type="text/css" rel="stylesheet" href="dist/bootstrap.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/eui/2.12.0/index.css">
</head>

<body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">捐赠物资管理</a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">

            </div>
        </form>
    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "common.menu.php" ?>

        <div id="content-wrapper">
            <div class="container-fluid" id="app">

                <el-dialog title="用款明细" :visible.sync="detailDialogVisible" width="30%" :before-close="handleClose">

                    <h6>捐款方</h6>
                    <p><span>{{dataList[current_id].income_donor }}</span>
                        <br />
                        <span>{{dataList[current_id].income_name }}</span>
                        <span>总金额{{ dataList[current_id].income_amount }}元</span><br />
                        <span>已使用{{ dataList[current_id].income_amount- dataList[current_id].income_balance}}元</span></p>
                    <h6>收款方</h6>
                    <div v-if="trackList.length > 0">
                        <div v-for="(item, index) in trackList">
                            <span>{{ item.expense_datetime.substring(0, 10) }} {{ item.expense_recipient }} {{ item.state_amount }} 元</span></p>
                        </div>
                    </div>
                    <div v-else>
                        暂无
                    </div>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="detailDialogVisible = false">确 定</el-button>
                    </span>
                </el-dialog>

                <el-dialog title="添加收入" :visible.sync="addDialogVisible" width="30%" :before-close="handleClose">
                    <el-form :model="income" ref="income" :rules="rules" label-width="80px">

                        <el-form-item label="金额" required>
                            <el-input v-model="income.amount" placeholder="金额">
                                <template slot="append">元</template>
                            </el-input>
                        </el-form-item>

                        <el-form-item label="捐赠方" required>
                            <el-input v-model="income.donor" placeholder="捐赠方"></el-input>
                        </el-form-item>
                        <el-form-item label="联系人" required>
                            <el-input v-model="income.contact" placeholder="联系人"></el-input>
                        </el-form-item>
                        <el-form-item label="联系电话" required>
                            <el-input v-model="income.telephone" placeholder="联系电话"></el-input>
                        </el-form-item>

                        <el-form-item label="地址">
                            <el-input v-model="income.address" placeholder="地址"></el-input>
                        </el-form-item>

                        <el-form-item class="text-center">
                            <el-button type="primary" @click="addPost('income')">提 交</el-button>

                        </el-form-item>

                    </el-form>
                </el-dialog>


                <div class="card mb-3" v-if="editMode==false">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        捐款明细 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>

                    <div class="card-header pull-right text-align:right">
                        <i class="fas fa-table"></i>
                        <button class="btn btn-primary" type="button" v-on:click="addDialog()">添加</button></div>

                    <div class="card-body" id="postlist">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!--th>证据ID</th-->
                                        <th>时间</th>
                                        <th>捐赠方</th>
                                        <th>金额(元)</th>
                                        <th>已使用(元)</th>
                                        <th>操作</th>

                                    </tr>
                                </thead>
                                <!--tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>标题</th>
                                        <th>操作</th>
                                    </tr>
                                </tfoot-->
                                <tbody v-for="(todo, index) in dataList">
                                    <tr>
                                        <!--td>[{{ index+1 }}] </td-->
                                        <td>
                                            <!--{{ todo.post_id }}-->{{ todo.income_datetime.substring(0, 10) }}</td>
                                        <td style="max-width:500px">{{ todo.income_donor }}</td>
                                        <td style="max-width:500px">{{ todo.income_amount }}</td>
                                        <td style="max-width:500px">{{ todo.income_amount - todo.income_balance }}</td>
                                        <td style="max-width:500px"> <button class="btn btn-primary" type="button" data-dismiss="modal" v-on:click="viewDetail(index)">使用明细</button></td>


                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="m-auto">
                            <!--button class="btn btn-primary" type="button" data-dismiss="modal">批量提交</button-->

                        </div>
                    </div>

                    <div class="card-footer small text-muted"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © 2020</span>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="dist/vue.js"></script>
    <!-- import Vue before Element -->
    <script src="dist/eui/2.12.0/index.js"></script>
    <!-- Add this after vue.js -->
    <script src="dist/axios.min.js"></script>
    <script src="dist/vue-router.js"></script>
    <script>
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }


        var api_url = "api.admin.income.php"

        let product_id = getQueryString('product_id');

        console.log('createdList')

        var app5 = new Vue({
            el: '#app',
            data: {
                doc_id: 0,
                deviceList: [],
                doc_title: "",
                doc_content: "",
                doc_model: "",
                tipMessage: "",
                logList: [],
                editMode: false,
                log_date: "",
                dataList: [],
                num: [],
                flag: [],
                detailDialogVisible: false,
                current_id: 0,
                trackList: [],
                addDialogVisible: false,
                income: {
                    amount: '',
                    donor: '',
                    contact: '',
                    telephone: '',
                    address: '',
                },
                rules: {},
            },



            methods: {
                handleChange: function(value) {
                    console.log(value);
                },


                open2() {
                    this.$message({
                        message: '更新成功',
                        type: 'success'
                    });
                },

                open4() {
                    this.$message.error('调拨数量超过需求');
                },

                open3() {
                    this.$message.error('调拨数量大于库存');
                },

                refreshForm: function() {
                    var that = this;
                    that.income.amount = "";
                    that.income.donor = "";
                    that.income.contact = "";
                    that.income.telephone = "";
                    that.income.address = "";
                },

                addPost: function(formName) {
                    var that = this;

                    this.$refs[formName].validate((valid) => {
                        if (!valid) {
                            return;
                        }
                    });

                    axios.get(api_url, {
                            params: {
                                action: 'addPost',
                                amount: that.income.amount,
                                donor: that.income.donor,
                                contact: that.income.contact,
                                telephone: that.income.telephone,
                                address: that.income.address,

                            }
                        })
                        .then(function(response) {
                            //JSON.parse(response.data);
                            console.log(response.data);
                            console.log(response.data['code']);

                            if (response.data['code'] == 1) {

                                that.showMessage();
                                
                                that.refreshForm();
                                that.getList()
                                that.handleClose();
                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },

                showMessage: function() {
                    this.$message({
                        message: '提交成功',
                        type: 'success'
                    });
                },

               

                transfer: function(index_id) {
                    var that = this;

                    if (parseInt(that.dataList[index_id].product_remain) < parseInt(that.num[index_id])) {
                        that.open3();
                        return;
                    }

                    if (parseInt(that.dataList[index_id].product_remain) < parseInt(that.num[index_id])) {
                        that.open4();
                        return;
                    }


                    axios.get(api_url, {
                            params: {
                                action: 'transferMaterial',
                                product_id: that.dataList[index_id].product_id,
                                req_id: that.dataList[index_id].req_id,
                                req_deduct: that.num[index_id]
                            }
                        })
                        .then(function(response) {
                            if (response.data['code'] == 1) {

                                that.open2();
                                // that.num[index_id] = 0;
                                that.tipMessage = '更新成功'
                                setTimeout(function() {
                                    that.tipMessage = ''
                                }, 1500)

                                that.getList()

                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });


                },


                viewDetail: function(index_id) {
                    var that = this;
                    that.detailDialogVisible = true
                    that.current_id = index_id;
                    that.getTracking(that.dataList[index_id].income_id);
                },

                addDialog: function() {
                    var that = this;
                    that.addDialogVisible = true

                },

                getTracking: function(index_id) {
                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: 'getTracking',
                                income_id: index_id
                            }
                        })
                        .then(function(response) {
                            if (response.status == 200) {
                                //post_list = response.data[0]
                                // console.log(post_list)
                                that.trackList = response.data;
                                console.log(that.trackList)
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },

                handleClose: function() {
                    var that = this;
                    that.detailDialogVisible = false;
                    that.addDialogVisible = false;
                    that.trackList = [];
                },


                getList: function() {
                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: 'listPost',
                                //product_id: product_id
                            }
                        })
                        .then(function(response) {
                            if (response.status == 200) {
                                //post_list = response.data[0]
                                // console.log(post_list)
                                that.dataList = response.data;
                                console.log(that.dataList)
                                let length = that.dataList.length
                                for (let i = 0; i < length; i++) {
                                    //that.num[i] = 0;
                                }
                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },



                getDate: function(date) {
                    var now = new Date(date),
                        y = now.getFullYear(),
                        m = now.getMonth() + 1,
                        d = now.getDate();
                    return y + "-" + (m < 10 ? "0" + m : m) + "-" + (d < 10 ? "0" + d : d) + " " + now.toTimeString().substr(0, 8);
                }
            },

            created: function() {
                var that = this;
                that.getList()
            },
        })
    </script>
</body>

</html>