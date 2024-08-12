<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const { props } = usePage();
const users = ref(props.users);

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Manage Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Management</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <h3 class="mb-3 text-xl">Manage Users</h3>
                    <div>
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created At
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ user.name }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ user.email }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ user.role }} <!-- Assuming you have a role field -->
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ new Date(user.created_at).toLocaleString() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <!-- Users pagination inline -->
                        <!-- <nav>
                            <ul class="pagination flex justify-between items-center w-full sm:w-auto text-sm mt-4 sm:mt-0">
                                <li v-if="users.value.prev_page_url" class="w-1/2 sm:w-auto">
                                    <a @click.prevent="users.value.prev_page_url" class="block w-full sm:w-auto text-center bg-white border border-gray-300 rounded-lg py-2 px-4 text-gray-700 hover:bg-gray-50" href="#">
                                        Previous
                                    </a>
                                </li>
                                <li v-if="users.value.next_page_url" class="w-1/2 sm:w-auto">
                                    <a @click.prevent="users.value.next_page_url" class="block w-full sm:w-auto text-center bg-white border border-gray-300 rounded-lg py-2 px-4 text-gray-700 hover:bg-gray-50" href="#">
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </nav> -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
