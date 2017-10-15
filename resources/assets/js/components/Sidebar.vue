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
        <li class="header">เมนูหลัก</li>
        <li :class="{ 'active': $route.name === 'dashboard' }">
          <router-link :to="{ name: 'dashboard' }">
            <i class="fa fa-star-o"></i> <span>ภาพรวม</span>
          </router-link>
        </li>
        <li :class="{ 'active': $route.name === 'car-register' }">
          <router-link :to="{ name: 'car-register' }">
            <i class="fa fa-edit"></i> <span>นำเข้าข้อมูลจดทะเบียน</span>
          </router-link>
        </li>
        <li :class="{ 'active': $route.name === 'customers' }">
          <router-link :to="{ name: 'customers' }">
            <i class="fa fa-book"></i> <span>สมุดรายชื่อลูกค้า</span>
          </router-link>
        </li>
        <li class="header">เมนูตั้งค่า</li>
        <li :class="{ 'active': $route.name === 'settings/company' }">
          <router-link :to="{ name: 'settings.company' }">
            <i class="fa fa-building"></i> <span>แก้ไขข้อมูลบริษัท</span>
          </router-link>
        </li>
        <li :class="{ 'active': $route.name === 'settings/employee' }">
          <router-link :to="{ name: '/settings/employee' }">
            <i class="fa fa-user-circle-o"></i> <span>เพิ่มผู้ใช้งานในระบบ</span>
          </router-link>
        </li>
        <li :class="{ 'active': $route.name === 'settings/car' }">
          <router-link :to="{ name: '/settings/car' }">
            <i class="fa fa-car"></i> <span>จัดการข้อมูลรถ</span>
          </router-link>
        </li>
        <li :class="{ 'active': $route.name === 'settings/payment' }">
          <router-link :to="{ name: '/settings/payment' }">
            <i class="fa fa-money"></i> <span>บัญชีธนาคาร</span>
          </router-link>
        </li>
        <li :class="{ 'active': $route.name === 'settings/service' }">
          <router-link :to="{ name: '/settings/service' }">
            <i class="fa fa-sitemap"></i> <span>ประเภทบริการ</span>
          </router-link>
        </li>
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
    }
  };
</script>