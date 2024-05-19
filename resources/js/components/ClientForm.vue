<template>
    <div>
        <div class="pb-3 border-b border-gray-200 mb-6">
            <div class="mx-auto">
                <h1
                    class="text-lg font-semibold text-gray-900 dark:text-white sm:text-xl"
                >
                    <span class="inline">Clients</span>
                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" aria-hidden="true" class="inline mx-1 h-6 w-6 text-gray-400 group-first:hidden md:mx-2" data-testid="flowbite-breadcrumb-separator" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="inline">Add New Client</span>
                </h1>
            </div>
        </div>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="client.name"
                />
                <span class="text-red-600" v-if="errors?.name">{{
                    errors.name[0]
                }}</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="text"
                    id="email"
                    class="form-control"
                    v-model="client.email"
                />
                <span class="text-red-600" v-if="errors?.email">{{
                    errors.email[0]
                }}</span>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input
                    type="text"
                    id="phone"
                    class="form-control"
                    v-model="client.phone"
                />
                <span class="text-red-600" v-if="errors?.phone">{{
                    errors.phone[0]
                }}</span>
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input
                    type="text"
                    id="address"
                    class="form-control"
                    v-model="client.address"
                />
            </div>
            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">City</label>
                    <input
                        type="text"
                        id="city"
                        class="form-control"
                        v-model="client.city"
                    />
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">Postcode</label>
                    <input
                        type="text"
                        id="postcode"
                        class="form-control"
                        v-model="client.postcode"
                    />
                </div>
            </div>

            <div class="text-right">
                <a href="/clients" class="btn btn-default">Cancel</a>
                <button @click="storeClient" class="btn btn-primary">
                    Create
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ClientForm",

    data() {
        return {
            errors: {},
            client: {
                name: "",
                email: "",
                phone: "",
                address: "",
                city: "",
                postcode: "",
            },
        };
    },

    methods: {
        storeClient() {
            axios
                .post(route("data.clients.store"), this.client)
                .then((data) => {
                    window.location.href = route('clients.show', { client: data.data.data.id});
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
