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
          <form @submit.prevent="saveItem" @keydown="form.onKeydown($event)">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-car"></i> ข้อมูลรถ</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>ประเภทรถ<span class="text-danger">*</span></label>
                    <v-select v-model="form.car.type" :options="types" :on-change="selectedType"></v-select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>ยี่ห้อรถ<span class="text-danger">*</span></label>
                    <v-select v-model="form.car.make" :options="makes" :on-change="selectedMake"></v-select>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>รุ่นรถ</label>
                    <input v-model="form.car.model" type="text" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>รุ่นปี ค.ศ.<span class="text-danger">*</span></label>
                    <input v-model="form.car.year" type="text" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>เลขทะเบียน<span class="text-danger">*</span></label>
                    <input v-model="form.car.license" type="text" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>จังหวัด<span class="text-danger">*</span></label>
                    <input v-model="form.car.province" type="text" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>ขนาดรถ<span class="text-danger">*</span></label>
                    <div class="input-group">
                     <input v-model="form.car.engine_size" type="text" class="form-control" required>
                      <span class="input-group-addon">CC</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>หมายเลขตัวรถ</label>
                    <input v-model="form.car.chassi_number" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>หมายเลขเครื่อง</label>
                    <input v-model="form.car.engine_number" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label>น้ำหนัก<span class="text-danger">*</span></label>
                    <div class="input-group">
                     <input v-model="form.car.weight" type="text" class="form-control" required>
                      <span class="input-group-addon">กก.</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-id-card-o"></i> ข้อมูลเจ้าของรถ</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>คำนำหน้า</label>
                    <input v-model="form.customer.title" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>ชื่อ<span class="text-danger">*</span></label>
                    <input v-model="form.customer.firstname" type="text" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>นามสกุล<span class="text-danger">*</span></label>
                    <input v-model="form.customer.lastname" type="text" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>เบอร์โทรฯ<span class="text-danger">*</span></label>
                    <input v-model="form.customer.phone" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>เลขที่บัตร<span class="text-danger">*</span></label>
                    <input v-model="form.customer.tax_id" type="text" class="form-control" required>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>สัญชาติ</label>
                    <input v-model="form.customer.nationality" type="text" class="form-control">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-7">
                  <div class="form-group">
                    <label>ที่อยู่</label>
                    <input v-model="form.customer.street" type="text" class="form-control">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>ตำบล / แขวง</label>
                    <thai-address-input 
                      type="subdistrict"
                      v-model="form.customer.subdistrict"
                      input-class="form-control"
                      @selected="onSelected"></thai-address-input>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>อำเภอ / เขต</label>
                    <thai-address-input 
                      type="district"
                      v-model="form.customer.district"
                      input-class="form-control"
                      @selected="onSelected"></thai-address-input>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-group">
                    <label>จังหวัด</label>
                    <thai-address-input
                      type="province"
                      v-model="form.customer.province"
                      input-class="form-control"
                      @selected="onSelected"></thai-address-input>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>รหัสไปรษณีย์</label>
                    <thai-address-input 
                      type="zipcode"
                      v-model="form.customer.zipcode"
                      input-class="form-control"
                      @selected="onSelected"></thai-address-input>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="pull-right">
            <button class="btn btn-primary" :disabled="form.busy"><i class="fa fa-save"></i> บันทึก</button>
            <button class="btn btn-warning" @click.prevent="reset"><i class="fa fa-refresh"></i> เริ่มใหม่</button>
          </div>
          </form>
        </div>
        <div class="col-sm-3 hidden-xs">
          <strong>Tips</strong>
          <div>
            การกรอกข้อมูลการจดทะเบียน<br><br>
            <span class="text-danger">*</span> หมายถึงข้อมูลที่ต้องกรอก<br><br>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import swal from 'sweetalert2'
  import Form from 'vform'
  export default {
    metaInfo () {
      return { 
        title: 'นำเข้าข้อมูลจดทะเบียน'
      }
    },
    data() {
      return {
        api: 'api/v1/register/car',
        types: Store.getters.types,
        makes: Store.getters.makes,
        form: new Form({
          car: {
            type: Store.getters.types[1],
            make: Store.getters.makes[0],
            type_id: 2,
            make_id: 1,
            model: '',
            year: '',
            license: '',
            province: '',
            engine_size: '',
            chassi_number: '',
            engine_number: '',
            weight: ''
          },
          customer: {
            title: '',
            firstname: '',
            lastname: '',
            phone: '',
            tax_id: '',
            nationality: 'ไทย',
            street: '',
            district: '',
            subdistrict: '',
            province: '',
            zipcode: ''
          }
        })
      }
    },
    methods: {
      saveItem (){
        this.form.post(this.api)
          .then(({ data }) => {
            swal({
              type: data.type,
              title: data.title,
              text: data.text
            })
            this.reset()
          })
      },
      reset(){
        this.form.reset()
      },
      selectedType(val, tag) {
        this.form.car.type_id = val.id
      },
      selectedMake(val, tag) {
        this.form.car.make_id = val.id
      },
      onSelected(address) {
        this.form.customer.subdistrict = address.subdistrict;
        this.form.customer.district = address.district;
        this.form.customer.province = address.province;
        this.form.customer.zipcode = address.zipcode;
      },
    }
  }
</script>
