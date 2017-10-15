<template>
  <div>
    <section class="content-header">
      <h1>
        นำเข้าข้อมูลจดทะเบียน
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Car register</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-car"></i> ข้อมูลรถ</h3>
            </div>
            <div class="box-body">
              I'm an Dashboard component!
            </div>
          </div>
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-id-card-o"></i> ข้อมูลเจ้าของรถ</h3>
            </div>
            <div class="box-body">
              I'm an Dashboard component!
            </div>
          </div>
          <div class="pull-right">
            <button class="btn btn-primary"><i class="fa fa-save"></i> บันทึก</button>
            <button class="btn btn-warning"><i class="fa fa-refresh"></i> เริ่มใหม่</button>
          </div>
        </div>
        <div class="col-sm-3"></div>
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
