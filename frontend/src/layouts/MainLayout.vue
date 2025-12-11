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
            <q-item clickable :active="menuItem.label === 'Outbox'" v-ripple>
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

    <q-footer elevated class="bg-grey-8 text-white">
      <q-toolbar>
        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg" />
          </q-avatar>
          <div>Title</div>
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>
  </q-layout>
</template>

<script>
import { ref } from 'vue'

function getMenuList() {
  return [
    {
      icon: 'home',
      label: 'Főmenű',
      separator: true,
    },
    {
      icon: 'send',
      label: 'Outbox',
    },
    {
      icon: 'drafts',
      label: 'Drafts',
      separator: true,
    },
    {
      icon: 'delete',
      label: 'Trash',
    },
    {
      icon: 'report',
      label: 'Spam',
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
