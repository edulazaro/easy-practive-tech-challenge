<template>
    <div>
        <div @click="closeModal" class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <!-- Prevents propagation of click events beyond this element -->
            <div   v-click-outside="closeModal" class="w-full max-w-2xl max-h-full bg-white rounded-lg shadow overflow-y-auto">

                <div
                    class="relative bg-white rounded-lg shadow"
                >
                    <div
                        class="flex items-center justify-between p-4 border-b rounded-t"
                    >
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-0"
                        >
                            Viewin Journal
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
                            {{ journal.date }}
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Select time</label>
                            {{ journal.content }}
                        </div>
                    </div>
                    <div
                        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b"
                    >
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

export default {
    name: "ViewJournalModal",

    props: ['client', 'journal'],

    data() {
        return {
            isShowModal: false,
            errors: {},
        };
    },
    methods: {
        closeModal() {
            this.isShowModal = false;
            this.$emit('unselect-client-journal');
        },
        showModal() {
            this.isShowModal = true;
        },
    },
};
</script>
