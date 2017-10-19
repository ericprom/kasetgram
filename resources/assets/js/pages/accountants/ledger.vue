<template>
  <div>
    <section class="content-header">
      <h1>
        {{config.title}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Settings</li>
        <li class="active">Types</li>
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
              <label class="col-sm-2 col-md-3 control-label">วันที่ใช้จ่าย<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <datepicker v-model="form.date_withdraw" :config="datepicker"></datepicker>
              </div>
            </div>
            <div class="form-group">
              <label for="ledgerWithdrawer" class="col-sm-2 col-md-3 control-label">ผู้เบิกจ่าย</label>
              <div class="col-sm-8 col-md-6">
                <input v-model="form.withdrawer" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">ประเภท<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <v-select v-model="form.expense" :options="expenses" :on-change="selectedExpense"></v-select>
              </div>
            </div>
            <div class="form-group">
              <label for="ledgerAmount" class="col-sm-2 col-md-3 control-label">จำนวนเงิน<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <input v-model="form.amount" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">รายละเอียด</label>
              <div class="col-sm-8 col-md-6">
               <textarea v-model="form.detail" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">จ่ายโดย</label>
              <div class="col-sm-8 col-md-6">
                <v-select v-model="form.payment" :options="payments" :on-change="selectedPayment"></v-select>
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
  import moment from 'moment'
  export default {
    metaInfo () {
      return { 
        title: this.config.title
      }
    },
    data() {
      return {
        payments: Store.getters.payments,
        expenses: Store.getters.expenses,
        search:{
          keyword:""
        },
        datepicker: {
          format: 'DD/MM/YYYY',
          useCurrent: false,
        },
        config:{
          table: 'itemTable',
          title: 'ค่าใช้จ่าย',
          api: '/api/v1/accountants/ledgers/',
          edit: true,
          hidden: ['id', 'expense_id', 'payment_id'],
          columns: [
            {
              name:'วันที่จ่าย',
              width: 10
            }, 
            {
              name:'ผู้เบิก',
              width: 20
            }, 
            {
              name:'รายละเอียด',
              width: 20
            }, 
            {
              name:'จำนวนเงิน',
              width: 20
            }, 
            {
              name:'ประเภท',
              width: 10
            }, 
            {
              name:'จ่ายโดย',
              width: 10
            }, 
          ],
        },
        form: new Form({
          id: 0,
          date_withdraw: moment().format('DD/MM/YYYY'),
          withdrawer: '',
          name: '',
          expense: Store.getters.expenses[0],
          payment: Store.getters.payments[0],
          branch_id: Store.getters.authUser.branch_id,
        }),
      };
    },
    mounted(){
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
        this.form.withdraw_date = this.saveDate(this.form.date_withdraw)
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
          if(key=='expense'){
            self.form['expense'] = self.checkExpense(item[key])
          }
          else if(key=='payment'){
            self.form['payment'] = self.checkPayment(item[key])
          }
          else{
            self.form[key] = item[key]
          }
        });
        this.form.date_withdraw  = this.displayDate(this.form.withdraw_date)
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
      checkExpense (item){
        var self = this;
        return _.find(self.expenses, function(val) {
          return item.id == val.id;
        });
      },
      checkPayment (item){
        var self = this;
        return _.find(self.payments, function(val) {
          return item.id == val.id;
        });
      },
      selectedExpense(val, tag) {
        this.form.expense_id = val.id
      },
      selectedPayment(val, tag) {
        this.form.payment_id = val.id
      }
    }
  }
</script>