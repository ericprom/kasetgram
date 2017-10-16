<template>
  <div>
    <section class="content-header">
      <h1>
        ข้อมูลบริษัท
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Settings</li>
        <li class="active">Company</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
          <form @submit.prevent="save" @keydown="form.onKeydown($event)"  class="form-horizontal">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-building"></i> แก้ไขข้อมูลบริษัท</h3>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 col-md-4 control-label">ชื่อบริษัท<span class="text-danger">*</span></label>
                  <div class="col-sm-8 col-md-4">
                    <input v-model="form.name" type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-md-4 control-label">ที่อยู่บริษัท</label>
                  <div class="col-sm-8 col-md-4">
                    <textarea v-model="form.address" class="form-control" rows="3" placeholder="รายละเอียดที่อยู่"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-md-4 control-label">เลขประจำตัวผู้เสียภาษี</label>
                  <div class="col-sm-8 col-md-4">
                    <input v-model="form.tax_number" type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-md-4 control-label">สำนักงาน</label>
                  <div class="col-sm-8 col-md-4">
                    <input v-model="form.branch" type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-md-4 control-label">เบอร์ออฟฟิศ</label>

                  <div class="col-sm-8 col-md-4">
                    <input v-model="form.phone" type="text" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-md-4 control-label">เบอร์แฟกซ์</label>
                  <div class="col-sm-8 col-md-4">
                    <input v-model="form.fax" type="text" class="form-control">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" :disabled="form.busy">
                  <i class="fa fa-save"></i> บันทึกข้อมูล
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-sm-3 hidden-xs">
          <strong>Tips</strong>
          <div>
            การกรอกข้อมูลบริษัท<br><br>
            <span class="text-danger">*</span> หมายถึงข้อมูลที่ต้องกรอก<br><br>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import Form from 'vform'

  export default {
    metaInfo () {
      return { title: 'เข้าสู่ระบบ' }
    },

    data: () => ({
      title: window.config.appName,
      form: new Form({
        email: 'surasak@promrat.com',
        password: '1q2w3e4r'
      }),
      remember: false
    }),

    methods: {
      save () {
        
      }
    }
  }
</script>
