<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-green-400 to-blue-500">
        <div class="text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Welcome to My Social Media</h1>
            <p class="text-lg mb-6">Share your thoughts, connect with friends, and discover what's new. Join us now!</p>
            <div class="flex justify-center space-x-4">
                <a href="/register">
                    <button class="bg-white text-blue-500 py-2 px-6 rounded hover:bg-gray-200">
                        Sign Up
                    </button>
                </a>
                <a href="/login">
                    <button class="bg-transparent border-2 border-white text-white py-2 px-6 rounded hover:bg-white hover:text-blue-500">
                        Login
                    </button>
                </a>
            </div>
        </div>
    </div>
</template>
