<template>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="http://www.newsshare.in/wp-content/uploads/2017/04/Miniclip-8-Ball-Pool-Avatar-15.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p v-if="authenticated">{{ user.name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
      </ul>
    </section>
  </aside>
</template>

<script>
  export default {
    name: 'Sidebar',
    computed: {
        user () {
            return Store.getters.authUser
        },
        authenticated () {
            return Store.getters.authCheck
        }
    },
  };
</script>