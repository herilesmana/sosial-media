<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-r from-green-400 to-blue-500">
    <div>
        <Link href="/">
            <ApplicationLogo class="text-5xl font-bold h-20 fill-current text-white" />
        </Link>
    </div>

    <div
        class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-lg sm:rounded-lg"
    >
        <slot />
    </div>
</div>

</template>
