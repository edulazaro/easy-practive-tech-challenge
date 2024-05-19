<template>
    <div>
        <div class="pb-3 border-b border-gray-200 mb-6">
            <div class="mx-auto flex justify-between items-center w-full">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white sm:text-xl">Clients</h1>
                <a :href="route('clients.create')" class="btn btn-primary">+ New Client</a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Number of Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clientsList" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
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
