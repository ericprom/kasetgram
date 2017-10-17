<template>
  <div>
    <section class="content-header">
      <h1>
        จัดการผู้ใช้
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Systems</li>
        <li class="active">Users</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
           <div class="box box-primary">
            <div class="box-body">
              <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control pull-right" v-model="search.keyword">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-default" @click.prevent="searchItem(search.keyword)">
                    <i class="fa fa-search"></i> ค้นหา
                  </button>
                </div>
              </div>
            </div>
          </div>
          <data-viewer 
            :configs="config" 
            :ref="config.table"
            @update="updateItem"
            @delete="deleteItem">
          </data-viewer>
          <button class="btn btn-default" @click.prevent="createItem"><i class="fa fa-plus"></i> เพิ่มผู้ใช้</button>
        </div>
        <div class="col-sm-3 hidden-xs">
          <strong>Tips</strong>
          <div>
            การกรอกข้อมูลบริษัท<br><br>
            <span class="text-danger">*</span> หมายถึงข้อมูลที่ต้องกรอก<br><br>
          </div>
        </div>
      </div>
    </section>
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form @submit.prevent="saveItem" @keydown="form.onKeydown($event)" class="form-horizontal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">จัดการข้อมูลผู้ใช้</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="userRole" class="col-sm-2 col-md-3 control-label">บริษัท<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <v-select v-model="form.company" :options="companies"></v-select>
              </div>
            </div>
            <div class="form-group">
              <label for="userRole" class="col-sm-2 col-md-3 control-label">ตำแหน่ง<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <v-select v-model="form.role" :options="roles"></v-select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">ชื่อ-สกุล<span class="text-danger">*</span></label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.name" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">ที่อยู่</label>

              <div class="col-sm-8 col-md-6">
                <textarea v-model="form.address" class="form-control" rows="3" placeholder="รายละเอียดที่อยู่" ></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">เบอร์โทร</label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.phone" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-1 col-md-2"></div>
              <div class="col-sm-10 col-md-8">
                <hr>
              </div>
              <div class="col-sm-1 col-md-2"></div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">อีเมล</label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.email" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">รหัสผ่าน</label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.password" type="text" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-flat" 
              :disabled="form.busy">บันทึก
            </button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import swal from 'sweetalert2'
  import Form from 'vform'
  export default {
    data() {
      return {
        search:{
          keyword:""
        },
        config:{
          table: 'itemTable',
          title: 'รายชื่อผู้ใช้',
          api: '/api/v1/users/',
          edit: true,
          hidden: ['id','branch_id'],
          columns: [
            {
              datafield:'name',
              name:'ชื่อ',
              width: 20
            }, 
            {
              datafield:'phone',
              name:'เบอร์โทร',
              width: 15
            }, 
            {
              datafield:'email',
              name:'อีเมล',
              width: 15
            }, 
            {
              datafield:'company.name',
              name:'บริษัท',
              width: 25
            },
            {
              datafield:'role.name',
              name:'ตำแหน่ง',
              width: 15
            }
          ],
        },
        roles: Store.getters.authRoles,
        companies: Store.getters.authCompanies,
        form: new Form({
          id: 0,
          company: Store.getters.authCompanies[0],
          role: Store.getters.authRoles[1],
          name: '',
          branch: '',
          address: '',
          phone: '',
        }),
      };
    },
    methods: {
      searchItem (){
        this.$refs.itemTable.searchData(this.search);
      },
      createItem (){
        this.form.reset()
        $("#create-item").modal('show')
      },
      saveItem (){
        if(this.form.id == 0){
          this.form.post(this.config.api)
            .then(({ data }) => {
              $("#create-item").modal('hide')
              this.$refs.itemTable.reloadData();
              this.form.reset()
            })
            .catch(function (error) {
            })
        }
        else{
          this.form.put(this.config.api+this.form.id)
            .then(({ data }) => {
              $("#create-item").modal('hide')
              this.$refs.itemTable.reloadData();
              this.form.reset()
            })
            .catch(function (error) {
            })
        }
      },
      updateItem (item){
        var self = this;
        Object.keys(item).forEach(function(key) {
          if(key=='role'){
            self.form['role'] = self.checkRole(item[key])
          }
          else if(key=='company'){
            self.form['company'] = self.checkCompany(item[key])
          }
          else{
            self.form[key] = item[key]
          }
        });
        $("#create-item").modal('show')
      },
      deleteItem (item){
        var self = this;
        swal({
          title: 'Are you sure?',
          text: 'ลบ '+item.name+' ออกจากระบบ',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ตกลง',
          cancelButtonText: 'ยกเลิก'
        }).then(function () {
          self.removeItem(item.id);
        }, function (dismiss) {})
      },
      removeItem (itemId) {
        axios.delete(this.config.api+itemId)
          .then(({ data }) =>{
            this.$refs.itemTable.reloadData();
            swal({
              type: data.code,
              title: data.title,
              text: data.message
            })
          })
          .catch(function (error) {
            swal({
              type: error.response.data.code,
              title: error.response.data.title,
              text: error.response.data.message
            })
          })
      },
      checkCompany (items){
        var self = this;
        var data = null
        _.find(items, function(val) {
          data = _.find(self.companies, function(item) {
            return item.id == val.id;
          });
        });
        return data
      },
      checkRole (items){
        var self = this;
        var data = null
        _.find(items, function(val) {
          data = _.find(self.roles, function(item) {
            return item.id == val.id;
          });
        });
        return data
      },
    }
  }
</script>