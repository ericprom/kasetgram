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
          api: '/api/v1/report/expenses/summary/'
        },
      }
    },
  }
</script>
