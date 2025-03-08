<script setup>
import { defineProps } from 'vue';
import { Link, Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    product: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String
});


</script>
<template>
    <app-layout :canLogin="canLogin" :canRegister="canRegister">

        <Head title="Product|Show" />
        <div class="max-w-lg mx-auto mt-8 p-4">
            <h1 class="text-2xl font-bold">{{ product.name }}</h1>
            <img v-if="product.image" :src="`/${product.image}`" class="w-full h-64 object-cover rounded mt-4"
                alt="Product Image">
            <p class="mt-4 text-gray-700">{{ product.description }}</p>
            <p class="text-lg font-semibold">Price: ${{ product.price }}</p>
            <p class="text-lg font-semibold">Stock: {{ product.stock }}</p>
            <Link :href="route('product.index')" class="text-blue-500 mt-4 inline-block">Back to Products</Link>
        </div>
    </app-layout>
</template>
