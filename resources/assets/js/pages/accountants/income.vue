<template>
  <div>
    <section class="content-header">
      <h1>
        {{config.title}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Accountants</li>
        <li class="active">Incomes</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
          <search-box @search="searchItem"></search-box>
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
              <label class="col-sm-2 col-md-3 control-label">วันที่รับเงิน<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <datepicker v-model="form.date_receive" :configs="datepicker"></datepicker>
              </div>
            </div>
            <div class="form-group">
              <label for="ledgerWithdrawer" class="col-sm-2 col-md-3 control-label">ผู้รับเงิน</label>
              <div class="col-sm-8 col-md-6">
                <input v-model="form.receiver" type="text" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 col-md-3 control-label">ประเภท<span class="text-danger">*</span></label>
              <div class="col-sm-8 col-md-6">
                <v-select v-model="form.farm" :options="farms" :on-change="selectedFarm"></v-select>
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
              <label class="col-sm-2 col-md-3 control-label">รับโดย</label>
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
        farms: Store.getters.farms,
        datepicker: {
          format: 'DD/MM/YYYY',
          useCurrent: false,
        },
        config:{
          table: 'itemTable',
          title: 'รายรับ',
          api: '/api/v1/accountants/incomes/',
          edit: true,
          hidden: ['id', 'farm_id', 'payment_id'],
          columns: [
            {
              name:'วันที่รับเงิน',
              width: 10
            }, 
            {
              name:'ผู้รับเงิน',
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
              name:'รับโดย',
              width: 10
            }, 
          ],
        },
        form: new Form({
          id: 0,
          date_receive: moment().format('DD/MM/YYYY'),
          receiver: '',
          name: '',
          farms: Store.getters.farms[0],
          payment: Store.getters.payments[0]
        }),
      };
    },
    mounted(){
    },
    methods: {
      searchItem (data){
        this.$refs.itemTable.searchData(data);
      },
      createItem (){
        this.form.reset()
        $("#create-item").modal('show')
      },
      saveItem (){
        this.form.receive_date = this.saveDate(this.form.date_receive)
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
          if(key=='farm'){
            self.form['farm'] = self.checkFarm(item[key])
          }
          else if(key=='payment'){
            self.form['payment'] = self.checkPayment(item[key])
          }
          else{
            self.form[key] = item[key]
          }
        });
        this.form.date_receive  = this.displayDate(this.form.receive_date)
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
              type: data.type,
              title: data.title,
              text: data.text
            })
          })
      },
      checkFarm (item){
        var self = this;
        return _.find(self.farms, function(val) {
          return item.id == val.id;
        });
      },
      checkPayment (item){
        var self = this;
        return _.find(self.payments, function(val) {
          return item.id == val.id;
        });
      },
      selectedFarm(val, tag) {
        this.form.farm_id = val.id
      },
      selectedPayment(val, tag) {
        this.form.payment_id = val.id
      }
    }
  }
</script>