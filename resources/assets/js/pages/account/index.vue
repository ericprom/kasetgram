<template>
  <div>
    <section class="content-header">
      <h1>
        แก้ไขข้อมูลส่วนตัว
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User Settings</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-9">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-user-o"></i> ข้อมูลส่วนตัว</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-2 col-md-4"></div>
                <div class="col-sm-8 col-md-4">
                  <div class="text-center">
                    <img :src="image" @click="trigger" class="img-circle" style="width: 150px; cursor: pointer; "/>
                    <input type="file" @change="onFileChange" ref="fileInput" class="hidden">
                  </div>
                </div>
                <div class="col-sm-2 col-md-4"></div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-info">บันทึกข้อมูล</button>
            </div>
          </div>
        </div>
        <div class="col-sm-3 hidden-xs">
          <strong>Tips</strong>
          <div>
            การกรอกข้อมูลส่วนตัว<br><br>
            <span class="text-danger">*</span> หมายถึงข้อมูลที่ต้องกรอก<br><br>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import axios from 'axios'
  import swal from 'sweetalert2'
  import Form from 'vform'
  import FormData from 'form-data'
  export default {
    data() {
      return {
        upload_avatar_api:'api/v1/upload/avatar',
        image: Store.getters.authUser.avatar
      }
    },
    methods: {
      trigger () {
        this.$refs.fileInput.click()
      },
      onFileChange(event) {
        var files = event.target.files || event.dataTransfer.files;
        if (!files.length)
          return;
        this.createImage(files[0]);
      },
      createImage(file) {
        var self = this;
        var image = new Image();
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = (event) => {
          this.uploadFile(reader.result, file.name);
          self.image = event.target.result;
        };
      },
      uploadFile(base64_image, filename) {
        var data = new FormData()
        data.append("base64_image", base64_image)
        data.append("filename", filename)
        axios.post(this.upload_avatar_api, data, {
          headers: {
            'Content-Type': undefined,
          }
        })
        .then(({ data }) =>{
          Store.dispatch('updateUser', data.user)
        })
        .catch(function (error) {
          swal({
            type: error.response.data.code,
            title: error.response.data.title,
            text: error.response.data.message
          })
        })
      }
    }
  }
</script>
