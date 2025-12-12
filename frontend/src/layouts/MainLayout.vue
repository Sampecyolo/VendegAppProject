<template>
  <q-layout view="hHh lpR fFf">
    <q-header elevated class="bg-primary text-white">
      <q-toolbar>
        <q-btn flat dense round icon="menu" @click="toggleLeftDrawer" aria-label="Menu" />
        <q-toolbar-title>VendégApp</q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      :width="200"
      :breakpoint="500"
      bordered
      :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-grey-3'"
    >
      <q-scroll-area class="fit">
        <q-list>
          <template v-for="(menuItem, index) in menuList" :key="index">
            <q-item clickable :active="menuItem.label === 'Outbox'" v-ripple :to="menuItem.to">
              <q-item-section avatar>
                <q-icon :name="menuItem.icon" />
              </q-item-section>
              <q-item-section> {{ menuItem.label }} </q-item-section>
            </q-item>
            <q-separator :key="'sep' + index" v-if="menuItem.separator" />
          </template>
        </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { ref } from 'vue'

function getMenuList() {
  return [
    {
      icon: 'home',
      label: 'Főmenü',
      separator: true,
      to: '/home', // Ez visz a kezdőlapra
    },
    {
      icon: 'bookmarks',
      label: 'Foglalások',
      to: '/bookings', // Ez visz az /outbox útvonalra
    },
    {
      icon: 'people',
      label: 'Vendégek',
      separator: true,
      to: '/guests',
    },
    {
      icon: 'delete',
      label: 'Trash',
      to: '/trash',
    },
    {
      icon: 'report',
      label: 'Spam',
      to: '/spam',
    },
  ]
}

export default {
  setup() {
    const leftDrawerOpen = ref(false)
    const menuList = getMenuList()
    return {
      leftDrawerOpen,
      menuList,
      toggleLeftDrawer() {
        leftDrawerOpen.value = !leftDrawerOpen.value
      },
    }
  },
}
</script>
<style>
footer {
  height: 7%;
}
</style>
