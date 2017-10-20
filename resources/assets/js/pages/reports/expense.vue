<template>
  <div>
    <section class="content-header">
      <h1>
        {{list.title}}
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
                  <v-select v-model="filter.timer" :options="timers" :on-change.prevent="selectedTime"></v-select>
                </div>
                <div class="col-sm-3">
                  <datepicker v-model="filter.start" :configs="datepicker" @dp-change.prevent="updateFilter"></datepicker>
                </div>
                <div class="col-sm-3">
                  <datepicker v-model="filter.end" :configs="datepicker" @dp-change.prevent="updateFilter"></datepicker>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-primary btn-block" @click.prevent="searchItem">
                    <i class="fa fa-filter"></i> Filter
                  </button>
                </div>
              </div>
            </div>
          </div>
          <data-viewer :configs="list" :ref="list.table"></data-viewer>
        </div>
        <div class="col-sm-3">
          <money-summary :configs="summary" :ref="summary.table"></money-summary>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import axios from 'axios'
  import moment from 'moment'
  export default {
    metaInfo () {
      return { 
        title: this.list.title
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
          from: this.saveDate(moment().format('DD/MM/YYYY')),
          to: this.saveDate(moment().format('DD/MM/YYYY')),
        },
        summary:{
          calss: 'col-sm-12',
          table: 'summaryTable',
          api: '/api/v1/report/expenses/summary',
          from: this.saveDate(moment().format('DD/MM/YYYY')),
          to: this.saveDate(moment().format('DD/MM/YYYY')),
        },
        list:{
          table: 'itemTable',
          title: 'รายงานค่าใช้จ่าย',
          api: '/api/v1/report/expenses/list',
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
        this.changeTime()
      },
      changeTime() {
        if(this.filter.timer.id !== 'custom') {
          var select = this.dateFilter(this.filter.timer.id)
          this.filter.start = select.start
          this.filter.end = select.end
        }
      },
      updateFilter () {
        this.changeTime()
      },
      searchItem (){
        this.filter.from = this.saveDate(this.filter.start)
        this.filter.to = this.saveDate(this.filter.end)
        this.$refs.itemTable.searchData(this.filter);
        this.getSummary()
      },
      getSummary(){
        this.$refs.summaryTable.searchData(this.filter.from, this.filter.to)
      }
    }
  }
</script>