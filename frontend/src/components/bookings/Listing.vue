<template>
  <div class="h-100">
    <div class="row">
      <div class="col-2">
        <h1>Bookings</h1>
      </div>
      <div class="col-10 text-end">
        <RouterLink class="btn btn-success mb-3" to="/book">Book a room!</RouterLink>
      </div>
    </div>
    
    <DataTable  
      class="h-100" 
      :rows="bookings"
      :pagination="pagination"
      :query="query"
      :loading="isLoading"
      top-pagination
      striped
      filter
      hoverable
      sortable
      @loadData="(e) => loadData(e)" >

      <template #thead="{sorting, sort}">
          <TableHead>ID</TableHead>
          <table-head sortable="room"
            :sort="sort"
            multiple
            @sorting="sorting">
              Room Name
          </table-head>
          <table-head sortable="user"
            :sort="sort"
            multiple
            @sorting="sorting">
              Booked By
          </table-head>
          <table-head sortable="from_date"
            :sort="sort"
            multiple
            @sorting="sorting">
              Date
          </table-head>
          <table-head sortable="to_date"
            :sort="sort"
            multiple
            @sorting="sorting">
              Time
          </table-head>
          <TableHead />
      </template>

      <template #tbody="{row}">
          <TableBody v-text="`${row.id}`"/>
          <TableBody v-text="`${row.room}`"/>
          <TableBody v-text="`${row.user}`"/>
          <TableBody v-text="`${row.from_date.toLocaleDateString()}`"/>
          <TableBody v-text="`${row.from_date.toLocaleTimeString()} - ${row.to_date.toLocaleTimeString()}`"/>
          <TableBody>
              <div class="btn-group">
                <button type="button" class="btn btn-outline-primary">
                  <i class="bi bi-pencil-fill"></i>
                  <span class="visually-hidden">Button</span>
                </button>
                <button type="button" class="btn btn-outline-danger">
                  <i class="bi bi-trash"></i>
                  <span class="visually-hidden">Button</span>
                </button>
              </div>
          </TableBody>
      </template>

      <template #empty>
        <TableBodyCell colspan="6" class="text-center">
          <span>No record found.</span>
        </TableBodyCell>
      </template>
    </DataTable>
  </div>
</template>

<script setup lang="ts">
  import router from '@/router';
  import BookingService, 
    { 
      Booking,
      BookingSearchPayload,
      BookingsResponse,
      BookingTable 
    } from '@/services/booking/booking-service';

  import { Ref, ref } from '@vue/reactivity';

  import {DataTable, TableHead, TableBody, TableBodyCell} from "@jobinsjp/vue3-datatable";
  import '@jobinsjp/vue3-datatable/dist/style.css';
  import { defineComponent } from '@vue/runtime-core';

  let bookings: Ref<Array<BookingTable>> = ref([]);

  const pagination = ref({})
  const query = ref({
      search: "",
      page: 1,
      perPage: 5,
  });
  const isLoading = ref(false)

  const bookingService = new BookingService();
  const username: Ref<string> = ref('');
  const password: Ref<string> = ref('');

  const loadData = async (e) => {
    query.value = e;
    isLoading.value = true

    const searchParams: BookingSearchPayload = {
      page: e.page,
      limit: e.per_page,
      search: e.search,
      sort: e.sort
    };

    const resp = await bookingService.index(searchParams);
    const data = resp.data as BookingsResponse;

    bookings.value = data.bookings.map((booking: Booking) => {
      const { id, room, user, to_date, from_date } = booking;
      return {
        id,
        room: room.name,
        user: user.name,
        from_date: (new Date(from_date)),
        to_date: (new Date(to_date))
      }
    });

    pagination.value = { 
      ...pagination.value,
      page: data.pagination.currentPage,
      total: data.pagination.total 
    }

    isLoading.value = false
  }
</script>

<style scoped>

</style>
