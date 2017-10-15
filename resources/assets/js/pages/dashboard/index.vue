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
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-id-card-o"></i> Dashboard Component</h3>
        </div>
        <div class="box-body">
          I'm an Dashboard component!
        </div>
        <div class="box-footer clearfix">
          <button class="btn btn-primary pull-right">
            บันทึก
          </button>
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
