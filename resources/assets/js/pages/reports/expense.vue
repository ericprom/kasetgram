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
          <filter-box @filter="summaryFilter"></filter-box>
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
        summary:{
          calss: 'col-sm-12',
          table: 'summaryTable',
          api: '/api/v1/report/expenses/summary/',
          from: '',
          to: '',
        },
        list:{
          table: 'itemTable',
          title: 'รายงานค่าใช้จ่าย',
          api: '/api/v1/report/expenses/list/',
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
      summaryFilter(data){
        this.$refs.itemTable.searchData(data)
        this.$refs.summaryTable.searchData(data)
      }
    }
  }
</script>