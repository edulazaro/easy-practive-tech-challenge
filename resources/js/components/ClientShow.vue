<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn" :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>

                    <div class="form-group">
                        <label for="bookingFilter">Filter Bookings:</label>
                        <select class="form-control cursor-pointer" id="bookingFilter" v-model="bookingFilter" @change="filterBookings">
                            <option value="all">All bookings</option>
                            <option value="past">Past bookings only</option>
                            <option value="future">Future bookings only</option>
                        </select>
                    </div>

                    <template v-if="bookings && bookings.length > 0">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Time</th>
                                    <th class="px-4 py-2 hidden md:table-cell">Notes</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in bookingsList" :key="booking.id" class="bg-white border-b">
                                    <td class="px-4 py-2">
                                        {{ booking.formatted_date }}
                                        <div class="font-normal mt-2 md:hidden">
                                            Notes: <span class="text-gray-500 ">{{ booking.notes }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 hidden md:table-cell">{{ booking.notes }}</td>
                                    <td class="px-4 py-2">
                                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="w-full bg-white rounded p-4 border border-gray-200 rounded-md" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">List of client journals</h3>
                        <client-journals :client="client" :journals='client.journals'></client-journals>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            bookings: this.client.bookings,
            currentTab: 'bookings',
            bookingFilter: 'all'
        }
    },

    methods: {
        filterBookings() {

            axios.get(`/data/clients/${this.client.id}/bookings`, { params: { filter: this.bookingFilter } }).then(response => {
                this.bookings = response.data;
            })
            .catch(error => {
                console.error('There was an error fetching the bookings:', error);
            });
        },

        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        }
    }
}
</script>
