<template>
  <div>
    <section class="content-header">
      <h1>
        จัดการผู้ใช้งานในระบบ
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Systems</li>
        <li class="active">Users</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list"></i> รายชื่อผู้ใช้งานในระบบ</h3>
            </div>
            <div class="box-body">
              I'm an Dashboard component!
            </div>
            <div class="box-footer">
              
            </div>
          </div>
        </div>
        <div class="col-sm-3 hidden-xs">
          <strong>Tips</strong>
          <div>
            การกรอกข้อมูลผู้ใช้งานในระบบ<br><br>
            <span class="text-danger">*</span> หมายถึงข้อมูลที่ต้องกรอก<br><br>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  export default {
    mounted() {
      console.log('Component ready.')
    }
  }
</script>
