<template>
    <div>
        <button
            @click="showModal"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
            type="button"
        >
            New journal entry
        </button>
        <div @click="closeModal" v-if="isShowModal" class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50"></div>
        
        <div v-if="isShowModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <!-- Prevents propagation of click events beyond this element -->
            <div   v-click-outside="closeModal" class="w-full max-w-2xl max-h-full bg-white rounded-lg shadow overflow-y-auto">

                <div class="relative bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">
                            New journal entry
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
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="col-span-2">
                            <label for="date" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Select time</label>
                            <input type="date" id="date" v-model="journal.date" class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5" required>
                            <span class="text-red-600" v-if="errors?.date">{{ errors.date[0] }}</span>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Select time</label>
                            <textarea id="content" v-model="journal.content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your journal here"></textarea>                    
                            <span class="text-red-600" v-if="errors?.content">{{ errors.content[0] }}</span>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b"
                    >
                        <button
                            @click="storeJournal"
                            type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        >
                            Add entry
                        </button>
                        <button
                            type="button"
                            @click="closeModal"
                            class="ml-2 py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
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

export default {
    name: "NewJournalModal",

    props: ['client'],

    data() {
        return {
            isShowModal: false,
            errors: {},
            journal: {
                date:  this.formatTodayDate(),
                content: "",
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
        formatTodayDate() {
            const today = new Date();
            const date = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
            return date;
        },
        storeJournal() {
            axios.post(route('data.clients.journals.store', { client: this.client.id }), this.journal)
            .then((data) => {
                this.closeModal();
                this.$emit('added-client-journal');
            })
            .catch((error) => {
                   this.errors = error.response.data.errors;
            });
        },
    },
};
</script>
