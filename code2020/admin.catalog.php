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

    <title>物资品类管理</title>

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
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="./catalog.html">物资类别</a>
                    </li>
                </ol>
                <!-- DataTables Example -->
                <div class="card mb-3" v-if="editMode==false">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        <!--跟踪管理-->

                        <el-row :gutter="20">
                            <el-col :span="2">
                                <div class="grid-content bg-purple"></div>
                            </el-col>
                            <el-col :span="6" align="center">
                                <div class="grid-content bg-purple">
                                    <el-input placeholder="搜索" v-model="search_value">
                                    </el-input>
                                </div>
                            </el-col>
                            <el-col :span="6">

                            </el-col>
                            <el-col :span="6">

                            </el-col>
                            <el-col :span="6" align="center">
                                <div class="grid-content bg-purple">
                                    <el-button type="primary">搜索
                                    </el-button>

                                    <el-button type="primary" @click="addDialogVisible = true">添加
                                    </el-button>
                                </div>
                            </el-col>
                        </el-row>
                    </div>

                    <el-dialog title="添加物资品类" :visible.sync="addDialogVisible" width="30%" :before-close="handleClose">

                        <el-form :model="catalog" ref="catalog" :rules="rules" label-width="80px">
                            <el-form-item label="品类名称" required prop="name">
                                <el-input v-model="catalog.name" placeholder="品类名称"></el-input>
                            </el-form-item>
                            <el-form-item label="备注">
                                <el-input v-model="catalog.desc" placeholder="备注"></el-input>
                            </el-form-item>

                            <el-form-item class="text-center">
                                <el-button type="primary" @click="addCatalog('catalog')">提 交</el-button>
                                <el-button @click="addDialogVisible = false">取 消</el-button>
                            </el-form-item>

                        </el-form>

                    </el-dialog>

                    <el-dialog title="编辑物资品类" :visible.sync="editDialogVisible" width="30%" :before-close="handleClose">

                        <el-form :model="catalog" ref="catalog" :rules="rules" label-width="80px">
                            <el-form-item label="品类名称" required prop="name">
                                <el-input v-model="catalog.name" placeholder="品类名称"></el-input>
                            </el-form-item>
                            <el-form-item label="备注">
                                <el-input v-model="catalog.desc" placeholder="备注"></el-input>
                            </el-form-item>

                            <el-form-item class="text-center">
                                <el-button type="primary" @click="updateCatalog('catalog')">提 交</el-button>
                                <el-button @click="editDialogVisible = false">取 消</el-button>
                            </el-form-item>

                        </el-form>

                    </el-dialog>


                    <div class="card-body" id="postlist">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!--th>证据ID</th-->
                                        <th>名称</th>
                                        <th>备注</th>
                                        <th></th>
                                        <th></th>
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
                                            <!--{{ todo.post_id }}-->{{ todo.cat_name }}</td>
                                        <td style="max-width:500px"></td>
                                        <td style="max-width:500px"></td>
                                        <td style="max-width:500px"></td>
                                        <td style="max-width:500px">
                                            <el-button type="primary" icon="el-icon-edit" v-on:click="editCatalog(index)">修改
                                            </el-button>
                                        </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
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
    <!-- Add this after vue.js -->
    <script src="dist/eui/2.12.0/index.js"></script>
    <script src="dist/axios.min.js"></script>
    <script src="dist/vue-router.js"></script>
    <script>
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }


        var api_url = "api.admin.catalog.php"

        let id = getQueryString('stu_id');

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
                search_value: "",
                date_start: "",
                date_end: "",
                addDialogVisible: false,
                editDialogVisible:false,
                catalog: {
                    id: "",
                    name: "",
                    desc: ""
                },
                rules: {
                    name: [{
                        required: true,
                        message: '请输入分类名称',
                        trigger: 'blur'
                    }],
                    
                }
            },



            methods: {

                addCatalog(formName) {

                    var that = this;
                    this.$refs[formName].validate((valid) => {
                        if (valid) {
                            //alert('submit!');
                            axios.get(api_url, {
                            params: {
                                action: "addCatalog",
                                cat_name: that.catalog.name,
                                cat_desc: that.catalog.desc,
                            }
                        })
                        .then(function(response) {
                            //JSON.parse(response.data);
                            console.log(response.data);
                            console.log(response.data['code']);
                            if (response.data['code'] == 1) {
                                that.getList()
                                that.addDialogVisible = false;
                                // that.open2();
                                that.catalog.name = "";
                                that.catalog.desc = "";
                                that.$message.success('添加成功');

                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                        } else {
                            console.log('error submit!!');
                            return false;
                        }
                    });                

                },


                editCatalog: function(index_id) {
                    var that = this;
                    that.editDialogVisible = true;
                    console.log(that.dataList[index_id]);
                    that.catalog.id = that.dataList[index_id].cat_id;
                    that.catalog.name = that.dataList[index_id].cat_name;
                    that.catalog.desc = that.dataList[index_id].cat_desc;

                },


                updateCatalog: function(formName) {
                    var that = this;
                    this.$refs[formName].validate((valid) => {
                        if (valid) {
                            //alert('submit!');
                            axios.get(api_url, {
                            params: {
                                action: "updateCatalog",
                                cat_id: that.catalog.id,
                                cat_name: that.catalog.name,
                                cat_desc: that.catalog.desc
                            }
                        })
                        .then(function(response) {
                            //JSON.parse(response.data);
                            console.log(response.data);
                            console.log(response.data['code']);
                            if (response.data['code'] == 1) {
                                that.getList()
                                that.editDialogVisible = false;
                                
                                // that.open2();
                                //that.catalog.id = "";
                                //that.catalog.name = "";
                                //that.catalog.desc = "";
                                that.$message.success('修改成功');

                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                        } else {
                            console.log('error submit!!');
                            return false;
                        }
                    });       

                },

                handleClose(done) {
                    var that = this;
                    that.addDialogVisible = false;
                    that.editDialogVisible = false;
                },

                searchDevice: function() {
                    var that = this;
                    //that.editMode = true


                },

              
                open2() {
                    this.$message({
                        message: '更新成功',
                        type: 'success'
                    });
                },

               


              


                signedEvidence: function(trans_id) {

                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: 'signedEvidence',
                                trans_id: trans_id
                            }
                        })
                        .then(function(response) {
                            if (response.data['code'] == 1) {
                                that.getList()
                                that.refreshForm()
                                //window.location.href = './index.html';
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },

                refreshForm: function() {
                    var that = this;

                    that.editMode = false;


                },

              
               

                getList: function() {
                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: 'listPost',
                                //post_id: this.post_id
                            }
                        })
                        .then(function(response) {
                            if (response.status == 200) {
                                //post_list = response.data[0]
                                // console.log(post_list)
                                that.dataList = response.data;
                                console.log(that.dataList)
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


        //获取当前日期 时间
        function todayTime() {
            var date = new Date();
            var curYear = date.getFullYear();
            var curMonth = date.getMonth() + 1;
            var curDate = date.getDate();
            if (curMonth < 10) {
                curMonth = '0' + curMonth;
            }
            if (curDate < 10) {
                curDate = '0' + curDate;
            }
            var curHours = date.getHours();
            var curMinutes = date.getMinutes();
            var curtime = curYear + ' 年 ' + curMonth + ' 月 ' + curDate + ' 日' + curHours + '时 ' + curMinutes + '分 ';
            return curtime;
        }
    </script>
</body>

</html>