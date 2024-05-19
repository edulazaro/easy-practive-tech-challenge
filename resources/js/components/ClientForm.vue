<template>
    <div>
        <div class="py-3 border-b border-gray-200 mb-6">
            <div class="mx-auto">
                <h1
                    class="text-lg font-semibold text-gray-900 sm:text-xl mb-0"
                >
                    <span class="inline">Clients</span>
                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" aria-hidden="true" class="inline mx-1 h-6 w-6 text-gray-400 group-first:hidden md:mx-2" data-testid="flowbite-breadcrumb-separator" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="inline">Add New Client</span>
                </h1>
            </div>
        </div>
        <div class="w-full bg-white rounded p-4 border border-gray-200 rounded-md max-w-lg mx-auto">
            <div class="form-group">
                <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Name</label>
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
                <label for="email" class="block mb-2 text-sm font-semibold text-gray-900">Email</label>
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
                <label for="phone" class="block mb-2 text-sm font-semibold text-gray-900">Phone</label>
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
                <label for="name" class="block mb-2 text-sm font-semibold text-gray-900">Address</label>
                <input
                    type="text"
                    id="address"
                    class="form-control"
                    v-model="client.address"
                />
            </div>
            <div class="block lg:flex lg:space-x-4">
                <div class="form-group flex-1">
                    <label for="city" class="block mb-2 text-sm font-semibold text-gray-900">City</label>
                    <input
                        type="text"
                        id="city"
                        class="form-control"
                        v-model="client.city"
                    />
                </div>
                <div class="form-group flex-1">
                    <label for="postcode" class="block mb-2 text-sm font-semibold text-gray-900">Postcode</label>
                    <input
                        type="text"
                        id="postcode"
                        class="form-control"
                        v-model="client.postcode"
                    />
                </div>
            </div>
            <div class="text-right">
                <a
                    :href="route('clients.index')"
                    class="mr-2 btn btn-default rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:ring-4 focus:ring-gray-100"
                >
                    Cancel
                </a>
                <button @click="storeClient" class="btn btn-primary">
                    Create
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { inject } from 'vue';

export default {
    name: "ClientForm",

    mounted() {
        this.toast = inject('toast');
    },

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
                .then((response) => {
                    window.location.href = route('clients.show', { client: response.data.data.id});
                })
                .catch((error) => {

                    this.toast.error({
                        title: 'Error!',
                        message: 'The client was not created. Please check the fields.',
                        delay: 5000
                    });

                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>
