<script setup>
import { Link, usePage } from '@inertiajs/vue3';

defineProps({ products: Array });
const page = usePage();
</script>

<template>
    <div class="max-w-4xl mx-auto mt-8 p-4">
        <h1 class="text-2xl font-bold mb-4">Product List</h1>
        <Link :href="route('product.create')" class="bg-blue-500 text-white px-4 py-2 rounded">Create
        Product</Link>
        <p v-if="page.props.message" class="text-green-600 mt-2">{{ page.props.message }}</p>
        <ul class="mt-4">
            <li v-for="product in products" :key="product.id"
                class="flex justify-between items-centerbg-gray-100 p-3 rounded mt-2">
                <div class="flex items-center space-x-4">
                    <img v-if="product.image" :src="`/${product.image}`" class="w-16 h-16 object-cover rounded"
                        alt="Product Image">
                    <span>{{ product.name }} - ${{ product.price }}</span>
                </div>
                <div>
                    <Link :href="route('product.show', product.id)" class="text-green-600 mr-3">View</Link>
                    <Link :href="route('product.edit', product.id)" class="text-blue-600 mr-3">Edit</Link>
                    <button @click="$inertia.delete(route('product.destroy', product.id))"
                        class="text-red-600">Delete</button>
                </div>
            </li>
        </ul>
    </div>
</template>
