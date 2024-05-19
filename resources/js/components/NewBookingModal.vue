<template>
    <div>
        <button @click="showModal" class="btn btn-primary">+ New Booking</button>
        <div
            @click="closeModal"
            v-if="isShowModal"
            class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50"
        ></div>

        <div
            v-if="isShowModal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div
                v-click-outside="closeModal"
                class="w-full max-w-2xl max-h-full bg-white rounded-lg shadow overflow-y-auto"
            >
                <div class="relative bg-white rounded-lg shadow">
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t"
                    >
                        <h3 class="text-xl font-semibold text-gray-900">
                            New booking
                        </h3>
                        <button
                            type="button"
                            @click="closeModal"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 grid grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <label
                                for="start_date"
                                class="block text-sm font-semibold text-gray-900"
                                >Start time</label
                            >
                            <input
                                type="datetime-local"
                                id="start_date"
                                v-model="booking.start"
                                class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5"
                                required
                            />
                            <span class="text-red-600" v-if="errors?.start">{{
                                errors.start[0]
                            }}</span>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label
                                for="end_date"
                                class="block text-sm font-semibold text-gray-900"
                                >End time</label
                            >
                            <input
                                type="datetime-local"
                                id="end_date"
                                v-model="booking.end"
                                class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5"
                                required
                            />
                            <span class="text-red-600" v-if="errors?.end">{{
                                errors.end[0]
                            }}</span>
                        </div>
                        <div class="col-span-2">
                            <label
                                for="description"
                                class="block mb-2 text-sm font-semibold text-gray-900"
                                >Notes</label
                            >
                            <textarea
                                id="notes"
                                v-model="booking.notes"
                                rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Write your notes here"
                            ></textarea>
                            <span class="text-red-600" v-if="errors?.notes">{{
                                errors.notes[0]
                            }}</span>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b"
                    >
                        <button @click="storeBooking" class="btn btn-primary mr-2">
                            Add booking
                        </button>
                        <button
                            type="button"
                            @click="closeModal"
                            class="btn btn-default rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:ring-gray-100"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { inject } from 'vue';

export default {
    name: "NewBoookingModal",

    props: ["client"],

    mounted() {
        this.toast = inject('toast');
    },

    data() {
        return {
            isShowModal: false,
            errors: {},
            booking: {
                start: this.formatTodayDate(),
                end: this.formatTodayDate(1),
                notes: "",
            },
        };
    },
    methods: {
        closeModal() {
            this.isShowModal = false;
        },
        showModal() {
            this.isShowModal = true;
        },
        formatTodayDate(addHours = 0) {
            const today = new Date();
            today.setHours(today.getHours() + addHours); // Add hours to the current time

            const year = today.getFullYear();
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            const hours = today.getHours().toString().padStart(2, '0');
            const minutes = today.getMinutes().toString().padStart(2, '0');

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        },
        storeBooking() {
            axios
                .post(
                    route("data.clients.bookings.store", {
                        client: this.client.id,
                    }),
                    this.booking
                )
                .then((data) => {
                    this.closeModal();

                    this.toast.success({
                        title: 'Success!',
                        message: 'The booking was correctly created.',
                        delay: 5000
                    });

                    this.$emit("added-client-booking");
                })
                .catch((error) => {

                    this.toast.error({
                        title: 'Error!',
                        message: 'It was not possible to create the booking. Plese check the fields.',
                        delay: 5000
                    });

                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
