<template>
  <div class="app-layout">
    <Appheader></Appheader>
    <Appsidebar></Appsidebar>
    <div class="content-wrapper">
      <child class="content"></child>
    </div>
    <Appfooter></Appfooter>
  </div>
</template>

<script>
import Appsidebar from '../components/Sidebar.vue'
import Appheader from '../components/Header.vue'
import Appfooter from '../components/Footer.vue'
export default {
  name: 'app-layout',

  components: {
    Appsidebar,
    Appheader,
    Appfooter
  }
}
</script>
