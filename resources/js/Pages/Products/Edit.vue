<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Head } from '@inertiajs/vue3';


const props = defineProps({
    product: Object, canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String
});



const form = useForm({
    name: props.product?.name || '',
    description: props.product?.description || '',
    price: props.product?.price || 0,
    stock: props.product?.stock || 0,
    image: null
});


const submit = () => {
    form.post(route('products.update', props.product.id));
};
</script>

<template>
    <app-layout :canLogin="canLogin" :canRegister="canRegister">

        <Head title="Product|Edit" />
        <div class="max-w-lg mx-auto mt-8 p-4">
            <h1 class="text-2xl font-bold">Edit Product</h1>

            <form @submit.prevent="submit" class="mt-4 space-y-3">
                <div>
                    <input v-model="form.name" placeholder="Name" class="border p-2 w-full">
                    <p v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</p>
                </div>

                <div>
                    <textarea v-model="form.description" placeholder="Description" class="border p-2 w-full"></textarea>
                    <p v-if="form.errors.description" class="text-red-500">{{ form.errors.description }}</p>
                </div>

                <div>
                    <input v-model="form.price" type="number" placeholder="Price" class="border p-2 w-full">
                    <p v-if="form.errors.price" class="text-red-500">{{ form.errors.price }}</p>
                </div>

                <div>
                    <input v-model="form.stock" type="number" placeholder="Stock" class="border p-2 w-full">
                    <p v-if="form.errors.stock" class="text-red-500">{{ form.errors.stock }}</p>
                </div>

                <div>
                    <input type="file" @change="event => form.image = event.target.files[0]" class="border p-2 w-full">
                    <p v-if="form.errors.image" class="text-red-500">{{ form.errors.image }}</p>
                </div>

                <button type="submit" :disabled="form.processing"
                    class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </form>
        </div>
    </app-layout>
</template>
