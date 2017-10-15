<template>
  <div class="text-center">
    <h2 class="mb-4">Page Not Found</h2>

    <div class="links">
      <router-link :to="{ name: 'welcome' }">
        กลับหน้าหลัก
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'not-found',

  layout: 'default'
}
</script>
