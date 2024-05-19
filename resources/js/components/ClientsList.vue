<template>
    <div>
        <div class="py-3 border-b border-gray-200 mb-6">
            <div class="mx-auto flex justify-between items-center w-full">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-xl mb-0">Clients</h1>
                <a :href="route('clients.create')" class="btn btn-primary">+ New Client</a>
            </div>
        </div>
        <div class="w-full bg-white rounded p-4 border border-gray-200 rounded-md">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-2 py-2">Client</th>
                        <th class="px-2 py-2 hidden hidden md:table-cell">Email</th>
                        <th class="px-2 py-2 hidden hidden lg:table-cell">Phone</th>
                        <th class="px-2 py-2 hidden hidden lg:table-cell">Bookings</th>
                        <th class="px-2 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white border-b">
                    <tr v-for="client in clientsList" :key="client.id">
                        <td class="px-2 py-2">
                            <div class="font-semibold"><a :href="route('clients.show', { client: client.id})">{{ client.name }}</a></div>
                            <div class="lg:hidden"><span class="font-semibold">Phone: </span><span class="text-gray-500 ">{{ client.phone }}</span></div>
                            <div class="md:hidden"><span class="font-semibold">Email: </span><span class="text-gray-500 ">{{ client.email }}</span></div>
                            <div class="lg:hidden"><span class="font-semibold">Bookings: </span><span class="text-gray-500 ">{{ client.bookings_count }}</span></div>
                        </td>
                        <td class="px-2 py-2 hidden md:table-cell">{{ client.email }}</td>
                        <td class="px-2 py-2 hidden lg:table-cell">{{ client.phone }}</td>
                        <td class="px-2 py-2 hidden hidden lg:table-cell">{{ client.bookings_count }}</td>
                        <td class="px-2 py-2 space-y-1 sm:space-y-0 sm:space-x-1 md:space-x-2">
                            <a
                                class="btn btn-primary btn-sm block w-full sm:w-auto sm:inline-block"
                                :href="route('clients.show', { client: client.id})"
                                >View</a
                            >
                            <button
                                class="btn btn-danger btn-sm block w-full sm:w-auto sm:inline-block"
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
