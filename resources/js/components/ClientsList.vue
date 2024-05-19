<template>
    <div>
        <div class="pb-3 border-b border-gray-200 mb-6">
            <div class="mx-auto flex justify-between items-center w-full">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-xl">Clients</h1>
                <a :href="route('clients.create')" class="btn btn-primary">+ New Client</a>
            </div>
        </div>
        <div class="w-full bg-white rounded p-4 border border-gray-200 rounded-md">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Number of Bookings</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-b">
                    <tr v-for="client in clientsList" :key="client.id">
                        <td class="px-4 py-2">{{ client.name }}</td>
                        <td class="px-4 py-2">{{ client.email }}</td>
                        <td class="px-4 py-2">{{ client.phone }}</td>
                        <td class="px-4 py-2">{{ client.bookings_count }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a
                                class="btn btn-primary btn-sm"
                                :href="`/clients/${client.id}`"
                                >View</a
                            >
                            <button
                                class="btn btn-danger btn-sm"
                                @click="deleteClient(client)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ClientsList",

    props: ["clients"],

    data() {
        return {
            clientsList: this.clients,
        };
    },

    methods: {
        deleteClient(client) {
            axios
                .delete(
                    route("data.clients.destroy", {
                        client: client.id,
                    })
                )
                .then((response) => {
                    this.clientsList = this.clientsList.filter(
                        (clientToCheck) => clientToCheck.id !== client.id
                    );
                })
                .catch((error) => {
                    console.error(
                        "There was an error deleting the client:",
                        error
                    );
                });
        },
    },
};
</script>
