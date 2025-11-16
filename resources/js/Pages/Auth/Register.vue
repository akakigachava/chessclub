<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '', // Add phone field
    membership_type: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <div>
            <InputLabel for="name" value="სახელი" />
            <TextInput
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
                autocomplete="name"
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
            <InputLabel for="email" value="ელექტრონული ფოსტა" />
            <TextInput
                id="email"
                v-model="form.email"
                type="email"
                class="mt-1 block w-full"
                required
                autocomplete="username"
            />
            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
            <InputLabel for="phone" value="ტელეფონის ნომერი" />
            <TextInput
                id="phone"
                v-model="form.phone"
                type="tel"
                class="mt-1 block w-full"
                required
                autocomplete="tel"
            />
            <InputError class="mt-2" :message="form.errors.phone" />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="პაროლი" />
            <TextInput
                id="password"
                v-model="form.password"
                type="password"
                class="mt-1 block w-full"
                required
                autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" value="დაადასტურეთ პაროლი" />
            <TextInput
                id="password_confirmation"
                v-model="form.password_confirmation"
                type="password"
                class="mt-1 block w-full"
                required
                autocomplete="new-password"
            />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>


        <div class="mt-4">
        <InputLabel for="membership_type" value="აირჩიეთ თქვენთვის სასურველი პაკეტი" />
        <select
            id="membership_type"
            v-model="form.membership_type"
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            required
        >
        <option value="საბაზისო">საბაზისო</option>
        <option value="პრემიუმი">პრემიუმი</option>
        <option value="ექსკლუზივი">ექსკლუზივი</option>
        </select>
        <InputError class="mt-2" :message="form.errors.membership_type" />
    </div>

        <div class="flex items-center justify-end mt-4">
            <Link
                :href="route('login')"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
                დარეგისტირებული ხართ?
            </Link>

            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                რეგისტრაცია
            </PrimaryButton>
        </div>
    </form>
</template>




<style scoped>
form {
    max-width: 400px;
    margin: 0 auto;
    background: #fff;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

label {
    font-weight: 600;
    color: #333;
}

input {
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 0.5rem;
    width: 100%;
}

button {
    background: #4f46e5;
    color: #fff;
    font-weight: 600;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    transition: background 0.2s;
}

button:hover {
    background: #4338ca;
}
</style>