<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue'

const { props } = usePage();
const posts = ref(props.posts);

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
    <Head title="Manage Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <h3 class="mb-3 text-xl">Posts Management</h3>
                    <div>
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Post Content
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Author
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Comments
                                    </th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Created At
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="post in posts.data" :key="post.id">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ post.content }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ post.user.name }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ post.comments_count }}
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ new Date(post.created_at).toLocaleString() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <!-- // Posts pagination inline -->
                        <nav>
                            <ul class="pagination
                                flex
                                justify-between
                                items-center
                                w-full
                                sm:w-auto
                                text-sm
                                mt-4
                                sm:mt-0
                            ">
                                <li v-if="posts.prev_page_url" class="w-1/2 sm:w-auto">
                                    <a @click.prevent="posts.prev_page_url" class="block w-full sm:w-auto text-center bg-white border border-gray-300 rounded-lg py-2 px-4 text-gray-700 hover:bg-gray-50" href="#">Previous</a>
                                </li>
                                <li v-if="posts.next_page_url" class="w-1/2 sm:w-auto">
                                    <a @click.prevent="posts.next_page_url" class="block w-full sm:w-auto text-center bg-white border border-gray-300 rounded-lg py-2 px-4 text-gray-700 hover:bg-gray-50" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
