<template>
  <div>
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Settings</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">รายได้</h3>
            </div>
            <div class="box-body">
              <vue-chart :config="configChart" :ref="configChart.table"></vue-chart>
            </div>
          </div>
          <data-viewer :configs="configIncome"></data-viewer>
          <data-viewer :configs="configExpense"></data-viewer>
        </div>
        <div class="col-sm-3">
          <money-summary :configs="configSummary"></money-summary>
        </div>
      </div>
      
    </section>
  </div>
</template>

<script>
  import axios from 'axios'
  import Chart from 'chart.js'
  export default {
    metaInfo () {
      return { 
        title: 'แดชบอร์ด'
      }
    },
    data() {
      return {
        configSummary:{
          class: 'col-sm-12',
          api: '/api/v1/report/dashboard/summary/'
        },
        configIncome:{
          title: 'รายได้ล่าสุด',
          api: '/api/v1/report/dashboard/incomes/',
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
              name:'รับโดย',
              width: 10
            }, 
          ],
        },
        configExpense:{
          title: 'รายจ่ายล่าสุด',
          api: '/api/v1/report/dashboard/expenses/',
          hidden: ['id', 'farm_id', 'payment_id'],
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
        },
        configChart: {
          table: 'chart',
          type: 'line',
          options:{
            fill: true,
            borderCapStyle: 'square',
            borderDashOffset: 0.0,
            pointBorderWidth: 1,
            pointHoverRadius: 8,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            pointHitRadius: 10,
            spanGaps: true,
            tooltips: {
              position: 'nearest',
              mode: 'label',
              callbacks: {
                label: function(tooltipItem, data) { 
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                },
              }
            }
          },
          data:{
            labels: ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
            datasets: [{
              label: "รายได้",
              backgroundColor: "rgba(34,135,180,0.4)",
              borderColor: "rgba(34,135,180,1)", 
              pointBackgroundColor: "rgba(255,255,255,1",
              pointHoverBackgroundColor: "rgba(34,135,180,1)",
              pointHoverBorderColor: "rgba(255,255,255,1)",
              data: [0,0,0,0,0,0,0,0,0,0,0,0],
            },
            {
              label: "รายจ่าย",
              backgroundColor: "rgba(0,213,91,0.4)",
              borderColor: "rgba(0,213,91,1)",
              pointBackgroundColor: "rgba(255,255,255,1",
              pointHoverBackgroundColor: "rgba(0,213,91,1)",
              pointHoverBorderColor: "rgba(255,255,255,1)",
              data: [0,0,0,0,0,0,0,0,0,0,0,0],
            }]
          }
        } 
      }
    },
    mounted() {
      this.getData()
    },
    methods: {
      getData (){
        var self = this
        axios.get('/api/v1/report/dashboard/chart')
          .then(({ data }) =>{
            self.configChart.data.datasets[0].data = Object.keys(data.incomes).map(function(key) {
              return [data.incomes[key]]
            });
            self.configChart.data.datasets[1].data = Object.keys(data.expenses).map(function(key) {
              return [data.expenses[key]]
            });
            this.$refs.chart.update()
          })
      }
    }
  }
</script>
