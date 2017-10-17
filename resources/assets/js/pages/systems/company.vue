<template>
  <div>
    <section class="content-header">
      <h1>
        จัดการข้อมูลบริษัท
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Systems</li>
        <li class="active">Role</li>
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
                  <button type="button" class="btn btn-default" @click.prevent="searchItem(search.keyword)"><i class="fa fa-search"></i></button>
                </div>
              </div>
            </div>
          </div>
          <data-viewer 
            :header="config.colomns" 
            :source="config.api" 
            :title="config.title"
            :edit="config.edit"
            :ref="config.table"
            @update="updateItem"
            @delete="deleteItem">
          </data-viewer>
          <button class="btn btn-default" @click.prevent="createItem">+ เพิ่มบริษัท</button>
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
            <h4 class="modal-title" id="myModalLabel">จัดการข้อมูลบริษัท</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">ชื่อบริษัท<span class="text-danger">*</span></label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.name" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">ที่อยู่บริษัท</label>

              <div class="col-sm-8 col-md-6">
                <textarea v-model="form.address" class="form-control" rows="3" placeholder="รายละเอียดที่อยู่" ></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">เลขที่ผู้เสียภาษี</label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.tax_id" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">สำนักงาน</label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.branch" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">เบอร์ออฟฟิศ</label>

              <div class="col-sm-8 col-md-6">
                <input v-model="form.phone" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">เบอร์แฟกซ์</label>

              <div class="col-sm-8 col-md-6">
                <input vg-model="form.fax" type="text" class="form-control">
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
          table: 'customerTable',
          edit: true,
          title: 'รายชื่อบริษัท',
          api: '/api/v1/companies',
          colomns: [
            {
              name:'ชื่อบริษัท',
              width: 40
            }, 
            {
              name:'ที่อยู่บริษัท',
              width: 25
            }, 
            {
              name:'เบอร์ออฟฟิศ',
              width: 25
            }
          ],
        },
        form: new Form({
          id: 0,
          name: '',
          branch: '',
          address: '',
          phone: '',
          fax: '',
          bramch_of: '',
          tax_id: '',
        }),
      };
    },
    methods: {
      searchItem (){
        this.$refs.customerTable.searchData(this.search);
      },
      createItem (){
        this.form.reset()
        $("#create-item").modal('show')
      },
      saveItem (){
        if(this.form.id == 0){
          this.form.post('/api/v1/companies')
            .then(({ data }) => {
              $("#create-item").modal('hide')
              this.$refs.customerTable.reloadData();
              this.form.reset()
            })
            .catch(function (error) {
            })
        }
        else{
          this.form.put('/api/v1/companies/'+this.form.id)
            .then(({ data }) => {
              $("#create-item").modal('hide')
              this.$refs.customerTable.reloadData();
              this.form.reset()
            })
            .catch(function (error) {
            })
        }
      },
      updateItem (item){
        var self = this;
        Object.keys(item).forEach(function(key) {
          self.form[key] = item[key]
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
        axios.delete('/api/v1/companies/'+itemId)
          .then(({ data }) =>{
            this.$refs.customerTable.reloadData();
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
      }
    }
  }
</script>