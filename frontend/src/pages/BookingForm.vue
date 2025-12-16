<template>
  <q-card flat bordered class="q-pa-md">
    <q-card-section>
      <div class="text-h6">Új foglalás hozzáadása</div>
    </q-card-section>

    <q-card-section>
      <q-form @submit="onSubmit" class="row q-col-gutter-md">
        <div class="col-12 col-md-2">
          <q-select
            v-model="form.roomNumber"
            :options="room_number"
            label="Szobaszám"
            outlined
            dense
            stack-label
          />
        </div>
        <div class="col-12 col-md-3">
          <q-input
            v-model="form.checkIn"
            type="date"
            label="Bejelentkezés"
            outlined
            dense
            stack-label
          />
        </div>
        <div class="col-12 col-md-3">
          <q-input
            v-model="form.checkOut"
            type="date"
            label="Kijelentkezés"
            outlined
            dense
            stack-label
          />
        </div>
        <div class="col-12 col-md-2">
          <q-input v-model="form.numberOfGuests" type="number" label="Vendégek" outlined dense />
        </div>
        <div class="col-12 col-md-2">
          <q-select
            v-model="form.paymentMethod"
            :options="payment_method"
            label="Fizetés"
            outlined
            dense
          />
        </div>
        <div class="col-12 col-md-2">
          <q-input v-model="form.paid" type="number" label="Fizetett" outlined dense />
        </div>

        <div class="col-12 text-right">
          <q-btn label="Mentés" type="submit" color="primary" icon="save" />
        </div>
      </q-form>
    </q-card-section>
  </q-card>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useQuasar } from 'quasar'

const room_number = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']

const payment_method = ['Készpénz', 'Bankkártya', 'Szépkártya', 'Átutalás', 'Ajándékutalvány']

const $q = useQuasar()

const SuccesfulPost = () => {
  $q.notify({
    message: 'Foglalás sikeresen hozzáadva!',
    caption: 'Az új foglalás megjelenik a listában.',
    color: 'positive',
  })
}

const FailedPost = () => {
  $q.notify({
    message: 'Foglalást nem sikerült hozzáadni!',
    caption: 'Ellenőrizd a megadott adatokat!',
    color: 'negative',
  })
}

const emit = defineEmits(['booking-added'])

const form = ref({
  roomNumber: '',
  checkIn: '',
  checkOut: '',
  numberOfGuests: 1,
  paid: 0,
  paymentMethod: '',
})

const onSubmit = async () => {
  try {
    await axios.post('http://localhost:8000/api/bookings', form.value)

    form.value = {
      roomNumber: '',
      checkIn: '',
      checkOut: '',
      numberOfGuests: 1,
      paid: 0,
      paymentMethod: 'cash',
    }

    emit('booking-added')
    SuccesfulPost()
  } catch (error) {
    console.error('Hiba a mentéskor:', error)
    FailedPost()
  }
}
</script>
