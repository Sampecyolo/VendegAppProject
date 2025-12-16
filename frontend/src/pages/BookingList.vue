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
              @click="toggleDetails(props)"
              :icon="props.expand ? 'remove' : 'add'"
              :loading="loadingGuests[props.row.id]"
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
                </tr>
                <tr v-for="guest in guestsMap[props.row.id]" :key="guest.id">
                  <td>{{ guest.fullName }}</td>
                  <td>{{ guest.address }}</td>
                  <td>{{ guest.phoneNumber }}</td>
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
const loadingGuests = ref({})
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

const guestsMap = ref({})
// Ez a függvény kezeli a lenyitást és az adatbetöltést
const toggleDetails = async (props) => {
  props.expand = !props.expand // Lenyitás/becsukás állapot váltása

  // Csak akkor kérjük le, ha lenyitjuk ÉS még nincs betöltve az adat ehhez az ID-hoz
  if (props.expand && !guestsMap.value[props.row.id]) {
    await getGuestbyBookingId(props.row.id)
  }
}

const getGuestbyBookingId = async (id) => {
  loadingGuests.value[id] = true
  try {
    // API hívás a foglalás ID-jával
    // A te példádban ez visszaadja a JSON tömböt (pl. Horvat Szabolcs...)
    const response = await axios.get(`http://localhost:8000/api/bookings/${id}/guests`)

    // Mentsük el a map-be a foglalás ID-ja alá a kapott tömböt
    guestsMap.value[id] = response.data // Vagy response.data.data, API-tól függően

  } catch (error) {
    console.error(`Hiba a vendégek lekérésekor (Booking ID: ${id}):`, error)
    guestsMap.value[id] = [] // Hiba esetén üres tömb, hogy ne próbálja újra végtelenségig
  } finally {
    loadingGuests.value[id] = false
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
