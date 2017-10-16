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
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list"></i> รายชื่อบริษัท </h3>
              <div class="box-tools pull-right">
                <span class="badge bg-light-blue">{{pagination.total}}</span>
              </div>
            </div>
            <div class="box-body">
              <table class="table table-hover">
                <tr>
                  <th width="30%">ชื่อบริษัท</th>
                  <th colspan="2">ที่อยู่</th>
                </tr>
                <tr>
                  <td colspan="4" class="text-vertical-center text-center" v-if="pagination.total==0"><h3>ไม่มีข้อมูลบริษัท</h3></td>
                </tr>
                <tr v-for="item in items">
                  <td>
                    <div>{{ item.name }}</div>
                  </td>
                  <td>{{ item.address }}</td>
                  <td>
                    <div class="pull-right">
                      <button type="button" class="btn btn-box-tool" @click.prevent="editItem(item.id)">
                        <i class="fa fa-edit" style="font-size: 18px;"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" @click.prevent="deleteItem(item)">
                        <i class="fa fa-ban" style="font-size: 18px;"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" @click.prevent="createItem"><i class="fa fa-user-plus"></i> เพิ่มบริษัท</button>
            </div>
          </div>
        </div>
        <div class="col-sm-3"></div>
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
        items: [],
        pagination: {
          total: 0, 
          per_page: 10,
          from: 1, 
          to: 0,
          current_page: 1
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
    computed: {
        isActived: function () {
            return this.pagination.current_page
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return []
            }
            var from = this.pagination.current_page - this.offset
            if (from < 1) {
                from = 1
            }
            var to = from + (this.offset * 2)
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page
            }
            var pagesArray = []
            while (from <= to) {
                pagesArray.push(from)
                from++
            }
            return pagesArray
        }
    },
    mounted : function(){
      this.getItems(this.pagination.current_page)
    },
    methods: {
      getItems: function(page){
        axios.get('/api/v1/auth/menus')
          .then(function (response) {
            console.log(response)
          })

          var self = this;
          axios.get('/api/v1/companies?page='+page)
          .then(function (response) {
            self.items = response.data.data.data
            self.pagination = response.data.pagination
          })
          .catch(function (error) {
            swal({
              type: error.response.data.code,
              title: error.response.data.title,
              text: error.response.data.message
            })
          })
      },
      createItem: function(){
        this.form.reset()
        $("#create-item").modal('show')
      },
      saveItem: function(){
        if(this.form.id == 0){
          this.form.post('/api/v1/companies')
            .then(({ data }) => {
              this.changePage(this.pagination.current_page)
              $("#create-item").modal('hide')
              this.form.reset()
            })
            .catch(function (error) {
            })
        }
        else{
          this.form.put('/api/v1/companies/'+this.form.id)
            .then(({ data }) => {
              this.changePage(this.pagination.current_page)
              $("#create-item").modal('hide')
              this.form.reset()
            })
            .catch(function (error) {
            })
        }
      },
      editItem: function(itemId){
          this.items.forEach((item, i) =>{
            if(item.id==itemId){
              this.form.keys().forEach(key => {
                this.form[key] = item[key]
              })
            }
          });
          $("#create-item").modal('show');
      },
      deleteItem: function(item){
        swal({
          title: 'Are you sure?',
          text: "ลบ "+item.name+" ออกจากระบบ",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'ตกลง',
          cancelButtonText: 'ยกเลิก'
        }).then(function () {
          axios.delete('/api/v1/companies/'+item.id)
            .then(({ data }) =>{
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

        })
      },
      changePage: function (page) {
          this.pagination.current_page = page
          this.getItems(page)
      }
    }
  }
</script>

