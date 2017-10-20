<template>
  <div>
    <section class="content-header">
      <h1>
        {{config.title}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Systems</li>
        <li class="active">Employees</li>
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
          <button class="btn btn-default" @click.prevent="createItem"><i class="fa fa-plus"></i> {{config.title}}</button>
        </div>
        <div class="col-sm-3 hidden-xs">
          <strong>Tips</strong>
          <div>
            การกรอกข้อมูล{{config.title}}<br><br>
            <span class="text-danger">*</span> หมายถึงข้อมูลที่ต้องกรอก<br><br>
          </div><br><br>
          <strong>Roles</strong>
          <div>
            ตำแหน่งและสิทธิ์ผู้ใช้<br><br>
            <span class="text-danger">*</span>admin หมายถึงเจ้าของบริษัท<br><br>
            <span class="text-danger">*</span>user หมายถึงพนักงานในบริษัท<br><br>
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
            <h4 class="modal-title" id="myModalLabel">{{config.title}}</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="userRole" class="col-sm-2 col-md-3 control-label">ตำแหน่ง<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <v-select v-model="form.role" :options="roles" :on-change="selectedRole"></v-select>
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
              <label class="col-sm-2 col-md-3 control-label">อีเมล<span class="text-danger">*</span></label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.email" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">รหัสผ่าน<span class="text-danger" v-if="form.id==0">*</span></label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.password" type="password" class="form-control" :required="form.id==0">
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
    metaInfo () {
      return { 
        title: this.config.title 
      }
    },
    data() {
      return {
        search:{
          keyword:""
        },
        config:{
          table: 'itemTable',
          title: 'บัญชีพนักงาน',
          api: '/api/v1/setting/users/',
          edit: true,
          hidden: ['id','branch_id'],
          columns: [
            {
              datafield:'name',
              name:'ชื่อ',
              width: 30
            }, 
            {
              datafield:'phone',
              name:'เบอร์โทร',
              width: 20
            }, 
            {
              datafield:'email',
              name:'อีเมล',
              width: 20
            }, 
            {
              datafield:'role.name',
              name:'ตำแหน่ง',
              width: 20
            }
          ],
        },
        roles: Store.getters.roles,
        form: new Form({
          id: 0,
          role: Store.getters.roles[1],
          name: '',
          branch: '',
          address: '',
          phone: '',
          role_id: 3
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
        }
        else{
          this.form.put(this.config.api+this.form.id)
            .then(({ data }) => {
              $("#create-item").modal('hide')
              this.$refs.itemTable.reloadData();
              this.form.reset()
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
        if(item.id == 1){
          swal({
              type: 'warning',
              title: 'Warning',
              text: 'คุณไม่สามารถลบผู้ดูแลระบบได้'
            })
        }
        else{
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
        }
      },
      removeItem (itemId) {
        axios.delete(this.config.api+itemId)
          .then(({ data }) =>{
            this.$refs.itemTable.reloadData();
            swal({
              type: data.type,
              title: data.title,
              text: data.text
            })
          })
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
      selectedRole(val, tag) {
        this.form.role_id = val.id
      }
    }
  }
</script>