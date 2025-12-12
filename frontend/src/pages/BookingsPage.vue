<template>
  <Booking-list ref="bookingListRef" />
  <Booking-form @booking-added="refreshTable" />
</template>

<script setup>
import { ref } from 'vue'
import BookingList from './BookingList.vue'
import BookingForm from './BookingForm.vue'

const bookingListRef = ref(null)
const refreshTable = () => {
  bookingListRef.value.fetchBookings()
}
</script>
