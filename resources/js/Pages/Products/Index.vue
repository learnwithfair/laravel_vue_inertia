<script setup>
import { Link, usePage, Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    products: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String
});

const page = usePage();
const showMessage = ref(!!page.props.flash?.success); // ✅ Initialize if flash message exists

// ✅ Auto-hide flash message after 3 seconds
onMounted(() => {
    if (showMessage.value) {
        setTimeout(() => {
            showMessage.value = false;
        }, 3000);
    }
});
</script>
<template>
    <app-layout :canLogin="canLogin" :canRegister="canRegister">

        <Head title="Products" />

        <div class="max-w-4xl mx-auto mt-8 p-4">
            <!-- ✅ Flash message with auto-hide -->
            <transition name="fade">
                <div v-if="showMessage"
                    class="mb-4 p-4 bg-green-100 text-green-700 rounded dark:bg-green-900 dark:text-green-300">
                    {{ page.props.flash.success }}
                </div>
            </transition>

            <h1 class="text-2xl font-bold mb-4">Product List</h1>

            <Link :href="route('product.create')" class="bg-blue-500 text-white px-4 py-2 rounded">
            Create Product
            </Link>

            <ul class="mt-4">
                <li v-for="product in products.data" :key="product.id"
                    class="flex justify-between items-center bg-gray-100 p-3 rounded mt-2">

                    <div class="flex items-center space-x-4">
                        <img v-if="product.image" :src="product.image" class="w-16 h-16 object-cover rounded"
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
    </app-layout>
</template>


<style scoped>
/* ✅ Fade transition effect */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
