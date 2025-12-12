<template>
  <div class="q-pa-md">
    <q-table flat bordered title="Foglalások" :rows="bookings" :columns="columns" row-key="id">
      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th auto-width />
          <q-th v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td auto-width>
            <q-btn
              size="sm"
              color="blue"
              round
              dense
              @click="props.expand = !props.expand"
              :icon="props.expand ? 'remove' : 'add'"
            />
          </q-td>
          <q-td v-for="col in props.cols" :key="col.name" :props="props">
            {{ col.value }}
          </q-td>
        </q-tr>
        <q-tr v-show="props.expand" :props="plus">
          <q-td colspan="100%">
            <div class="text-left">Részletek a szobához: {{ props.row.roomNumber }}</div>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'

const columns = [
  {
    name: 'roomNumber',
    required: true,
    label: 'Szobaszám',
    align: 'left',
    field: 'roomNumber',
    sortable: true,
  },
  {
    name: 'checkIn',
    align: 'center',
    label: 'Bejelentkezés',
    field: 'checkIn',
    sortable: true,
  },
  {
    name: 'checkOut',
    label: 'Kijelentkezés',
    field: 'checkOut',
    sortable: true,
  },
  {
    name: 'numberOfGuests',
    label: 'Vendégek száma',
    field: 'numberOfGuests',
  },
  {
    name: 'paid',
    label: 'Fizetett összeg',
    field: 'paid',
  },
]

const bookings = ref([])
const getBookings = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/bookings')
    const nyersAdatok = response.data.data

    bookings.value = nyersAdatok.map((booking) => ({
      id: booking.id,
      roomNumber: booking.roomNumber,
      checkIn: booking.checkIn,
      checkOut: booking.checkOut,
      numberOfGuests: booking.numberOfGuests,
      paid: booking.paid,
      paymentMethod: booking.paymentMethod,
    }))
  } catch (error) {
    console.error('Hiba a foglalások lekérésekor:', error)
  }
}

onMounted(() => {
  getBookings()
})

defineExpose({
  getBookings,
})
</script>
