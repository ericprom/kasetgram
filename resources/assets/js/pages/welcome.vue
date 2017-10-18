<template>
  <div>
    <div class="top-right links">
      <template v-if="authenticated">
        <router-link :to="{ name: 'dashboard' }">
          หน้าแดชบอร์ด
        </router-link>
      </template>
      <template v-else>
        <router-link :to="{ name: 'login' }">
          เข้าสู่ระบบ
        </router-link>
      </template>
    </div>

    <div class="text-center">
      <div class="title mb-4">
        <img :src="inspection_logo">
        <br>
        {{ title }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: 'default',

  metaInfo () {
    return { 
      title: 'หน้าหลัก' 
    }
  },

  computed: {
      authenticated () {
        return Store.getters.authCheck
      }
    },

  data(){
    return {
      inspection_logo: "images/inspection.png",
      title: "Vehicle Inspection Management System"
    }
  }
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 35px;
}
</style>
