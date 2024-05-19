<template>
    <div>
        <div class="border-b border-gray-200 mb-6">
            <div class="mx-auto md:flex justify-between items-center w-full">
                <h3 class="mb-3 md:mb-0">List of client journals</h3>
                <new-journal-modal
                    :client="client"
                    @added-client-journal="getJournals"
                />
            </div>
        </div>

        <div class="w-full" v-if="selectedJournal">
            <view-journal-modal
                :journal="selectedJournal"
                @unselect-client-journal="unSelectJournal"
            />
        </div>
        <div class="w-full">
            <div class="bg-white rounded mt-4">
                <div v-if="journalsList && journalsList.length > 0">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th class="px-2 py-2">
                                    <span class="hidden lg:inline-block"
                                        >Time</span
                                    >
                                    <span class="lg:hidden">Booking</span>
                                </th>
                                <th class="px-2 py-2 hidden lg:table-cell">
                                    Content
                                </th>
                                <th class="px-2 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="journal in journalsList"
                                class="border-b"
                                :key="journal.id"
                            >
                                <td class="px-2 py-2">
                                    {{ journal.formatted_date }}
                                    <div class="lg:hidden">
                                        <span class="font-semibold"
                                            >Content: </span
                                        ><span class="text-gray-500">{{
                                            journal.excerpt
                                        }}</span>
                                    </div>
                                </td>

                                <td class="px-2 py-2 hidden lg:table-cell">
                                    {{ journal.excerpt }}
                                </td>
                                <td
                                    class="px-2 py-2 space-y-1 xl:space-y-0 xl:space-x-1 xl:space-x-2"
                                >
                                    <button
                                        class="btn btn-primary btn-sm block w-full xl:w-auto xl:inline-block"
                                        @click="selectJournal(journal)"
                                    >
                                        View
                                    </button>
                                    <button
                                        class="btn btn-danger btn-sm block w-full xl:w-auto xl:inline-block"
                                        @click="deleteJournal(journal)"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else>
                    <p class="text-center">The client has no journals.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { inject } from "vue";

export default {
    name: "ClientJournals",

    props: {
        client: Object,
        journals: Array,
    },

    mounted() {
        this.toast = inject("toast");
    },

    data() {
        return {
            journalsList: [],
            selectedJournal: null,
        };
    },

    created() {
        this.journalsList = [...this.journals];
    },

    methods: {
        getJournals() {
            axios
                .get(
                    route("data.clients.journals.index", {
                        client: this.client.id,
                    })
                )
                .then((response) => {
                    this.journalsList = response.data.collection;
                })
                .catch((error) => {
                    console.error(
                        "There was an error fetching the journals:",
                        error
                    );
                });
        },

        selectJournal(journal) {
            this.selectedJournal = journal;
        },

        unSelectJournal() {
            this.selectedJournal = null;
        },

        deleteJournal(journal) {
            axios
                .delete(route("data.journals.destroy", { journal: journal.id }))
                .then(() => {
                    this.toast.success({
                        title: "Success!",
                        message: "The journal was correctly deleted",
                        delay: 5000,
                    });
                    this.getJournals();
                })
                .catch((error) => {
                    this.toast.error({
                        title: "Success!",
                        message: "Failed to delete journal: " + error.message,
                        delay: 5000,
                    });
                });
        },
    },
};
</script>
