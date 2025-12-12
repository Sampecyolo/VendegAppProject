<template>
  <q-card flat bordered class="q-pa-md">
    <q-card-section>
      <div class="text-h6">Új foglalás hozzáadása</div>
    </q-card-section>

    <q-card-section>
      <q-form @submit="onSubmit" class="row q-col-gutter-md">
        <div class="col-12 col-md-2">
          <q-input v-model="form.roomNumber" type="number" label="Szobaszám" outlined dense />
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
            :options="['cash', 'credit_card']"
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

// Definiáljuk az eseményt, amit a szülő felé küldünk
const emit = defineEmits(['booking-added'])

const form = ref({
  roomNumber: '',
  checkIn: '',
  checkOut: '',
  numberOfGuests: 1,
  paid: 0,
  paymentMethod: 'cash',
})

const onSubmit = async () => {
  try {
    // Adatok küldése az API-nak
    await axios.post('http://localhost:8000/api/bookings', form.value)

    // Űrlap alaphelyzetbe állítása
    form.value = {
      roomNumber: '',
      checkIn: '',
      checkOut: '',
      numberOfGuests: 1,
      paid: 0,
      paymentMethod: 'cash',
    }

    // JELEZZÜK a szülőnek, hogy kész a mentés!
    emit('booking-added')
  } catch (error) {
    console.error('Hiba a mentéskor:', error)
  }
}
</script>
