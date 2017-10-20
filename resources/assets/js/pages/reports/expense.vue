<template>
  <div>
    <section class="content-header">
      <h1>
        {{config.title}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Reports</li>
        <li class="active">Expenses</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
           <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-sm-4">
                  <v-select v-model="filter.timer" :options="timers" :on-change="selectedTime"></v-select>
                </div>
                <div class="col-sm-3">
                  <datepicker v-model="filter.start" :config="datepicker"></datepicker>
                </div>
                <div class="col-sm-3">
                  <datepicker v-model="filter.end" :config="datepicker"></datepicker>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-primary btn-block" @click.prevent="searchItem">
                    <i class="fa fa-filter"></i> Filter
                  </button>
                </div>
              </div>
            </div>
          </div>
          <data-viewer :configs="config" :ref="config.table"></data-viewer>
        </div>
        <div class="col-sm-3 hidden-xs">
          <strong>Tips</strong>
          <div>
            ดูข้อมูล{{config.title}}<br><br>
            สามารถเลือกดูเฉพาะช่วงวันได้<br><br>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import moment from 'moment'
  export default {
    metaInfo () {
      return { 
        title: this.config.title
      }
    },
    data() {
      return {
        timers: Store.getters.timers,
        datepicker: {
          format: 'DD/MM/YYYY',
          useCurrent: false,
        },
        filter:{
          timer: Store.getters.timers[1],
          start: moment().format('DD/MM/YYYY'),
          end: moment().format('DD/MM/YYYY'),
          from: moment().format('DD/MM/YYYY'),
          to: moment().format('DD/MM/YYYY')
        },
        config:{
          table: 'itemTable',
          title: 'รายงานค่าใช้จ่าย',
          api: '/api/v1/report/expenses/',
          edit: false,
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
              width: 30
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
        }
      };
    },
    methods: {
      selectedTime(val, tag) {
        this.filter.timer = val
        if(this.filter.timer.id !== 'custom') {
          var select = this.dateFilter(this.filter.timer.id);
          this.filter.start = select.start;
          this.filter.end = select.end;
        }
      },
      searchItem (){
        this.filter.from = this.saveDate(this.filter.start)
        this.filter.to = this.saveDate(this.filter.end)
        this.$refs.itemTable.searchData(this.filter);
      }
    }
  }
</script>