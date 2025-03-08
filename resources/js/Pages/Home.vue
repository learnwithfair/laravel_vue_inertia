<script setup>
import { Link, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String
});

</script>

<template>
    <AppLayout :canLogin="canLogin" :canRegister="canRegister">

        <Head title="Home" />
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Welcome to Product Manager</h1>

                    <p class="text-lg text-gray-700 mb-4">
                        This is a simple Product management application built with Laravel, Vue.js, and Inertia.js.
                    </p>

                    <p class="text-lg text-gray-700 mb-6">
                        Use the navigation menu to manage your product and stay organized.
                    </p>

                    <div class="mt-8">
                        <Link :href="route('product.index')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        View product
                        </Link>

                        <Link :href="route('product.create')"
                            class="ml-4 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create New Product
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
