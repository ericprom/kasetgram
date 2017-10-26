<template>
  <div>
    <section class="content-header">
      <h1>
        บันทึกรายรับ
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Incomes</li>
      </ol>
    </section>
    <section class="content">
      
    </section>
  </div>
</template>

<script>
  import swal from 'sweetalert2'
  import Form from 'vform'
  export default {
    metaInfo () {
      return { 
        title: 'บันทึกรายรับ'
      }
    },
    data() {
      return {
        form: new Form({
          title: '',
        })
      }
    },
    methods: {
    }
  }
</script>
