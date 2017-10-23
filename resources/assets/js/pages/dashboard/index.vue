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
              <vue-chart type="line" :data="chartData"></vue-chart>
            </div>
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">บริการตรวจสภาพรถล่าสุด</h3>
            </div>
            <div class="box-body">
              I'm an Dashboard component!
            </div>
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">บริการต่อประกัน</h3>
            </div>
            <div class="box-body">
              I'm an Dashboard component!
            </div>
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">บริการต่อพรบ</h3>
            </div>
            <div class="box-body">
              I'm an Dashboard component!
            </div>
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">บริการต่อทะเบียน</h3>
            </div>
            <div class="box-body">
              I'm an Dashboard component!
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <money-summary :configs="config"></money-summary>
        </div>
      </div>
      
    </section>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        config:{
          class: 'col-sm-12',
          api: '/api/v1/report/dashboard/summary/'
        },
        chartData: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "ตรวจสภาพรถ",
            fill: true,
            backgroundColor: "rgba(34,135,180,0.4)",
            borderColor: "rgba(34,135,180,1)", 
            borderCapStyle: 'square',
            borderDash: [], 
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "black",
            pointBackgroundColor: "white",
            pointBorderWidth: 1,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "rgba(34,135,180,1)",
            pointHoverBorderColor: "white",
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            pointHitRadius: 10,
            data: [65, 59, 80, 81, 56, 55, 40, 66 ,60,55,30,78],
            spanGaps: true,
          },
          {
            label: "ต่อพรบ",
            fill: true,
            backgroundColor: "rgba(0,213,91,0.4)",
            borderColor: "rgba(0,213,91,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "black",
            pointBackgroundColor: "white",
            pointBorderWidth: 1,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "rgba(0,213,91,1)",
            pointHoverBorderColor: "white",
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            pointHitRadius: 10,
            data: [10, 20, 60, 95, 64, 78, 90, 78,70,40,70,89],
            spanGaps: false,
          }]
      } 
      }
    }
  }
</script>
