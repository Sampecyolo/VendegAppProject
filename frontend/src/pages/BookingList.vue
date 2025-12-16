<template>
  <div flat bordered class="q-pa-md">
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

        <q-tr v-show="props.expand" :props="props">
          <q-td colspan="100%">
            <div class="row items-center q-gutter-md">
              <strong>Műveletek:</strong>
              <q-btn
                push
                color="negative"
                label="Törlés!"
                @click="deleteBooking(props.row.id)"
                icon="delete"
              />

              <table>
                <tr>
                  <th>Vendég teljes neve:</th>
                  <th>Vendég Lakcíme:</th>
                  <th>Vendég Telefonszáma</th>
                  <th>Vendég beszélt nyelve</th>
                </tr>
                <tr>

                </tr>
              </table>
            </div>
          </q-td>
        </q-tr>
      </template>
    </q-table>
  </div>
</template>

<script setup>
import axios from 'axios'
import { ref, onMounted } from 'vue'
import { useQuasar } from 'quasar'
const $q = useQuasar()

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

const getGuestbyBookingId = async (bookingId) => {
  try {
    const response = await axios.get(`http://localhost:8000/api/bookings/${bookingId}/guests`)
    return response.data.data
  } catch (error) {
    console.error('Hiba a vendégek lekérésekor:', error)
    return []
  }
}

const deleteBooking = async (id) => {
  if (!confirm('Biztosan szeretnéd törölni a foglalást?')) {
    return
  }

  try {
    await axios.delete(`http://localhost:8000/api/bookings/${id}`)

    getBookings()

    $q.notify({
      color: 'positive',
      message: 'Foglalás sikeresen törölve',
      icon: 'check',
    })
  } catch (error) {
    console.log('Hiba a törlés közben', error)
    $q.notify({
      color: 'negative',
      message: 'Hiba történt a törlés során',
      icon: 'report_problem',
    })
  }
}





onMounted(() => {
  getBookings()
})

defineExpose({
  getBookings,
})
</script>
