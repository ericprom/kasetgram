<template>
  <header class="main-header">
    <a class="logo">
      <span class="logo-mini"><b>A</b>LTE</span>
      <span class="logo-lg"><b>Admin LTE</b></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu" v-if="authenticated">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="http://www.newsshare.in/wp-content/uploads/2017/04/Miniclip-8-Ball-Pool-Avatar-15.png" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ user.name }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <img src="http://www.newsshare.in/wp-content/uploads/2017/04/Miniclip-8-Ball-Pool-Avatar-15.png" class="img-circle" alt="User Image">

                <p>
                  {{ user.name }} - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a @click.prevent="logout" class="btn btn-default btn-flat">{{ $t('logout') }}</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
  export default {
    name: 'Header',
    data: () => ({
        appName: window.config.appName
    }),
    computed: {
        user () {
            return Store.getters.authUser
        },
        authenticated () {
            return Store.getters.authCheck
        }
    },
    methods: {
        logout () {
            // Log out the user.
            Store.dispatch('logout')

            // Redirect to login.
            this.$router.push({ name: 'welcome' })
        }
    }
  };
</script>