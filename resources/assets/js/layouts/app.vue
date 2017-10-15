<template>
  <div class="app-layout">
    <Appheader></Appheader>
    <Appsidebar></Appsidebar>
    <div class="content-wrapper">
      <child></child>
    </div>
  </div>
</template>

<script>
import Appsidebar from '../components/Sidebar.vue'
import Appheader from '../components/Header.vue'
export default {
  name: 'app-layout',

  components: {
    Appsidebar,
    Appheader
  }
}
</script>
