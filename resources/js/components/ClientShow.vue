<template>
    <div>
        <div class="pb-3 border-b border-gray-200 mb-6">
            <div class="mx-auto">
                <h1
                    class="text-lg font-semibold text-gray-900 sm:text-xl"
                >
                    <span class="inline">Clients</span>
                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" aria-hidden="true" class="inline mx-1 h-6 w-6 text-gray-400 group-first:hidden md:mx-2" data-testid="flowbite-breadcrumb-separator" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="inline">{{ client.name }}</span>
                </h1>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            <div>
                <div
                    class="w-full bg-white rounded p-4 border border-gray-200 rounded-md"
                >
                    <h2>Client Info</h2>

                    <div class="flex items-center mb-2 text-sm">
                        <div class="block ms-2 font-semibold text-gray-600 pr-3">
                            Name
                        </div>
                        <div>{{ client.name }}</div>
                    </div>
                    <div class="flex items-center mb-2 text-sm text-sm">
                        <div class="block ms-2 font-semibold text-gray-600 pr-3">
                            Email
                        </div>
                        <div>{{ client.email ? client.email : '-' }}</div>
                    </div>
                    <div class="flex items-center mb-2 text-sm">
                        <div class="block ms-2 font-semibold text-gray-600 pr-3">
                            Phone
                        </div>
                        <div>{{ client.phone ? client.phone : '-'  }}</div>
                    </div>
                    <div class="flex items-center mb-2 text-sm">
                        <div class="block ms-2 font-semibold text-gray-600 pr-3">
                            Address
                        </div>
                        <div>
                            <span >{{ client.address }}<br/></span>
        
                            {{ client.postcode ? client.postcode : '' }}
                            {{ client.city ? (' ' + client.city) : '' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div>
                    <button
                        class="btn"
                        :class="{
                            'btn-primary': currentTab == 'bookings',
                            'btn-default': currentTab != 'bookings',
                        }"
                        @click="switchTab('bookings')"
                    >
                        Bookings
                    </button>
                    <button
                        class="btn"
                        :class="{
                            'btn-primary': currentTab == 'journals',
                            'btn-default': currentTab != 'journals',
                        }"
                        @click="switchTab('journals')"
                    >
                        Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div
                    class="bg-white rounded p-4"
                    v-if="currentTab == 'bookings'"
                >
                    <h3 class="mb-3">List of client bookings</h3>

                    <div class="form-group">
                        <label for="bookingFilter">Filter Bookings:</label>
                        <select
                            class="form-control cursor-pointer"
                            id="bookingFilter"
                            v-model="bookingFilter"
                            @change="getBookings"
                        >
                            <option value="all">All bookings</option>
                            <option value="past">Past bookings only</option>
                            <option value="future">Future bookings only</option>
                        </select>
                    </div>

                    <template v-if="bookings && bookings.length > 0">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50"
                            >
                                <tr>
                                    <th class="px-4 py-2">Time</th>
                                    <th class="px-4 py-2 hidden md:table-cell">
                                        Notes
                                    </th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="booking in bookings"
                                    :key="booking.id"
                                    class="bg-white border-b"
                                >
                                    <td class="px-4 py-2">
                                        {{ booking.formatted_date }}
                                        <div class="font-normal mt-2 md:hidden">
                                            Notes:
                                            <span class="text-gray-500">{{
                                                booking.notes
                                            }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 hidden md:table-cell">
                                        {{ booking.notes }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <button
                                            class="btn btn-danger btn-sm"
                                            @click="deleteBooking(booking)"
                                        >
                                            Delete
                                        </button>
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
                <div
                    class="w-full bg-white rounded p-4 border border-gray-200 rounded-md"
                    v-if="currentTab == 'journals'"
                >
                    <h3 class="mb-3">List of client journals</h3>
                    <client-journals
                        :client="client"
                        :journals="client.journals"
                    ></client-journals>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ClientShow",

    props: ["client"],

    data() {
        return {
            bookings: this.client.bookings,
            currentTab: "bookings",
            bookingFilter: "all",
        };
    },

    methods: {
        getBookings() {
            axios
                .get(
                    route("data.clients.bookings.index", {
                        client: this.client.id,
                    }),
                    {
                        params: { when: this.bookingFilter },
                    }
                )
                .then((response) => {
                    this.bookings = response.data;
                })
                .catch((error) => {
                    console.error(
                        "There was an error fetching the bookings:",
                        error
                    );
                });
        },

        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(
                route("data.bookings.destroy", { booking: booking.id })
            );

            this.getBookings();
        },
    },
};
</script>
