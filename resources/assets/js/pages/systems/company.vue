<template>
  <div>
    <section class="content-header">
      <h1>
        จัดการข้อมูลบริษัท
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Systems</li>
        <li class="active">Role</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-list"></i> รายชื่อบริษัท</h3>
            </div>
            <div class="box-body">
              <table class="table table-hover">
                <tr>
                  <th width="30%">ชื่อบริษัท</th>
                  <th colspan="2">ที่อยู่</th>
                </tr>
                <tr>
                  <td colspan="4" class="text-vertical-center text-center"><h3>ไม่มีข้อมูลบริษัท</h3></td>
                </tr>
                <tr>
                  <td class="text-vertical-center">
                    <div>ชื่อบริษัท</div>
                  </td>
                  <td class="text-vertical-center">ที่อยู่</td>
                  <td>
                    <div class="pull-right">
                      <button type="button" class="btn btn-box-tool">
                        <i class="fa fa-edit" style="font-size: 18px;"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool">
                        <i class="fa fa-ban" style="font-size: 18px;"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary"><i class="fa fa-user-plus"></i> เพิ่มบริษัท</button>
            </div>
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
